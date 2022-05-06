<?php

namespace App\EventSubscriber\Doctrine;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserSubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }


    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        
    }

    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        if (!$user = $this->getUser($eventArgs)) {
            return;
        }

        $this->encodePassword($user);
    
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        if (!$user = $this->getUser($eventArgs)) {
            return;
        }

        $this->encodePassword($user);
    }

    private function encodePassword(User $user)
    {
        if (!$user->getPlainPassword()) {
            return;
        }
    
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            )
        );
      
    }

    public function getUser(LifecycleEventArgs $eventArgs): ?User
    {
        $user = $eventArgs->getEntity();

        if (!$user instanceof User) {
            return null;
        }

        return $user;
    }
}