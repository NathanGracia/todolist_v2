<?php

namespace App\Tests;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testAccessToIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/task');

        $this->assertResponseIsSuccessful();
    }

    public function testAccessToCreateForm(): void
    {
        //todo connexion
        $client = static::createClient();
        $crawler = $client->request('GET', '/task/new');

        $this->assertResponseIsSuccessful();
    }
   
}
