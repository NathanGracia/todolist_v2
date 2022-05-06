<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testAccessToCreateUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/new');

        $this->assertResponseIsSuccessful();
    }
 
}
