<?php
namespace App\Security;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';
    const CREATE = 'create';
    const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Task` objects
        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
    

        $user = $token->getUser();
        
        // you know $subject is a Task object, thanks to `supports()`
        /** @var Task $task */
        $task = $subject;

     

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($task, $user);
            case self::EDIT:
                return $this->canEdit($task, $user);
            case self::DELETE:
                return $this->canDelete($task, $user);
            case self::CREATE:
                return !empty($user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Task $task, $user): bool
    {
        // if they can edit, they can view || if task has no user, they can view anyway
        if ($this->canEdit($task, $user) || empty($task->getUser())) {
            return true;
        }
        return false;
    }

    private function canEdit(Task $task, $user): bool
    {    
        //must be author, even if there is no author on the task
        return $user === $task->getUser() && !empty($task->getUser());
    }
    private function canDelete(Task $task, $user): bool
    {    
        
        if ($this->canEdit($task, $user) ) {
            return true;
        }
        return false;   }
    
  
}