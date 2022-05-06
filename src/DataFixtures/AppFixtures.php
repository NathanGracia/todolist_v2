<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $task = new Task();
            $task->setTitle('Tache  '.$i);
            $task->setContent(mt_rand(10, 100));
            $task->setCreatedAt(new \DateTimeImmutable('now'));
            $manager->persist($task);
        }

        $manager->flush();
    }
}
