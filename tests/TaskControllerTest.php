<?php

namespace App\Tests;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

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
    public function testAccessViewAnoTask(): void
    {
       
        $client = static::createClient();
        $crawler = $client->request('GET', '/task/2');

        $this->assertResponseIsSuccessful();
    }
    public function testAccessViewPrivateTask(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('nathan@email.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/task/1');

        $this->assertResponseIsSuccessful();
    }
    public function testAccessEditPrivateTask(){
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('nathan@email.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/task/1/edit');
        
        $this->assertResponseIsSuccessful();
    }
    public function testAccessDeletePrivateTask(){
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('nathan@email.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/task/1/delete');
        
        $this->assertResponseIsSuccessful();
        //todo fix route
    } 
    public function testAccessDeniedDeleteAnoTask(){
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('nathan@email.fr');

        // simulate $testUser being logged in
        $client->loginUser($testUser);
        $crawler = $client->request('GET', '/task/2/edit');
        
        $this->assertResponseStatusCodeSame(403);
    }
   
}
