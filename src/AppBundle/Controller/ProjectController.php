<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Entity\Project;
use AppBundle\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Project controller.
 *
 * @Route("project")
 */
class ProjectController extends Controller
{
    /**
     * Lists all project entities.
     *
     * @Route("/", name="project_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        // $routeName = $request->get('_route');
        // var_dump($routeName);
        // die();
        $em = $this->getDoctrine()->getManager();
        $userid = $this->get('security.token_storage')->getToken()->getUser()->getId();

        $projects = $em->getRepository('AppBundle:Project')->findBy(array('user'=> $userid));
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $projects,
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );
    
        // parameters to template
        // return $this->render('article/list.html.twig', ['pagination' => $pagination]);

        return $this->render('project/index.html.twig', array(
            'projects' => $pagination,
        ));
    }

    /**
     * Creates a new project entity.
     *
     * @Route("/new", name="project_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $project = new Project();
        $form = $this->createForm('AppBundle\Form\ProjectType', $project,array('validation_groups' => array('new')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $project->setUser($user);
            $file = $project->getImage()->getUrl();
            $fileName = $file->getClientOriginalName().'.'.$file->guessExtension();
            $project->getImage()->setUrl($fileName);
            $file->move($this->getParameter('uploads_directory'),$fileName);
            $em->persist($project);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Post a ete ajouter');

            return $this->redirectToRoute('project_show', array('id' => $project->getId()));
        }

        return $this->render('project/new.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a project entity.
     *
     * @Route("/{id}", name="project_show")
     * @Method("GET")
     */
    public function showAction(Project $project)
    {
        $deleteForm = $this->createDeleteForm($project);

        return $this->render('project/show.html.twig', array(
            'project' => $project,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing project entity.
     *
     * @Route("/{id}/edit", name="project_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Project $project)
    {
        $oldImage = $project->getImage()->getUrl();
        $deleteForm = $this->createDeleteForm($project);
        $editForm = $this->createForm('AppBundle\Form\ProjectType', $project);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Post a ete editer');
            $file = $project->getImage()->getUrl();
            if(!empty($file)){
                $em = $this->getDoctrine()->getManager();

                $fileName = $file->getClientOriginalName() . '.' . $file->guessExtension();
                $project->getImage()->setUrl($fileName);
                $file->move($this->getParameter('uploads_directory'),$fileName);
                $em->persist($project);
                $this->getDoctrine()->getManager()->flush();

                // $file->move($this->getParameter('uploads_category'),$fileName);
            } else {
                $project->getImage->setUrl($oldImage);
            }

            return $this->redirectToRoute('project_edit', array('id' => $project->getId()));
        }

        return $this->render('project/edit.html.twig', array(
            'project' => $project,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a project entity.
     *
     * @Route("/{id}", name="project_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Project $project)
    {
        $form = $this->createDeleteForm($project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Post a ete deleted');

        }

        return $this->redirectToRoute('project_index');
    }

    /**
     * Creates a form to delete a project entity.
     *
     * @param Project $project The project entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Project $project)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('id' => $project->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
