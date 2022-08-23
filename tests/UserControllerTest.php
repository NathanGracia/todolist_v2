<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class UserControllerTest extends WebTestCase
{
    public function testAccessToCreateUser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/new');

        $this->assertResponseIsSuccessful();
    }
       public function testLogin(): void
    {
       
        $client = static::createClient();
        $client->request('GET', '/login');
  
        $crawler = $client->submitForm('Sign in', [
            'email' => 'nathan@email.fr',
            'password' => '0000'
        ]);
        //alpha
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
    public function testInvalidCredentials(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        //bravo
        $crawler = $client->submitForm('Sign in', [
            'email' => 'nathaan@email.fr',
            'password' => '0000'
        ]);
        $client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-danger', 'Invalid credentials.');
        $this->assertResponseIsSuccessful();
    } 
    public function testLogout(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('nathan@email.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/logout');
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue ');
    }  
      public function testEdit(): void
    {
        //charlie
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('nathan@email.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/user/1/edit');
             // test e.g. the profile page
       
        $crawler = $client->submitForm('Update', [
            
            'user[email]' => 'nathan@email.fr',
            'user[username]' => 'newUsername',
            'user[plainPassword][first]' => '0000',
            'user[plainPassword][second]' => '0000'
        ]); 
     
        $client->followRedirect();
    
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('td:nth-child(5)', 'newUsername');
    }
    
  
  
}
