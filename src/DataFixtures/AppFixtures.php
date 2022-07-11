<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $task = new Task();
            $task->setTitle('Tache  '.$i);
            $task->setContent(mt_rand(10, 100));
            $task->setCreatedAt(new \DateTimeImmutable('now'));
            $manager->persist($task);
        }
        //user
        $user = new User();
        $user->setEmail('nathan@email.fr');
        $user->setUsername('nathan');

        $password = $this->hasher->hashPassword($user, '0000');
        $user->setPlainPassword($password);
        

        $manager->persist($user);
        $manager->flush();
    }
}
