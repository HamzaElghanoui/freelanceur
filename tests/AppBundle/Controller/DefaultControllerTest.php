<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Tests\Calculator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $calculator = new Calculator;
        $sum = $calculator->add(2,3);
        $this->assertEquals($sum, 5);
        // $this->assertTrue(true);
        // $this->assertFalse(false);
    }


    public function testEdit(){
        $this->assertFalse(false);
    }
}
