<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProjectController extends Controller
{
    /**
     * @Route("/project")
     */
    public function indexAction()
    {
        return $this->render('@App/Project/index.html.twig', array(
            // ...
        ));
    }

}
