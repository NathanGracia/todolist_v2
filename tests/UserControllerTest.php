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
    public function testCreateUserForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        
        $crawler = $client->submitForm('Sign in', [
            'email' => 'nathan@email.fr',
            'password' => '0000'
        ]);
        $this->assertResponseIsSuccessful();
    }
 
}
