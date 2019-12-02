<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Tests\Calculator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ProjectControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $response = $client->getResponse();
        $responseContent = $response->getContent();
        // echo($response->getStatusCode());
        // die();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
