<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Product;
use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User(1);
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $project = new Project();
            $project->setName('product '.$i);
            $project->setDescription('description '.$i);
            $project->setPrice(mt_rand(10, 100));
            $project->setUser($user);
            $manager->persist($project);
        }

        $manager->flush();
    }
}

?>
