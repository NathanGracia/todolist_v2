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
     public function testSubmitCreateValidData()
    {
        $formData = [
            'test' => 'test',
            'test2' => 'test2',
        ];

        $model = new Task();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TaskType::class, $model);

        $expected = new Task();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    } 

}
