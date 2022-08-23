# To-do list Documentation : Authentication

To add authentication to the project, I used the basic Symfony authentication process. Here is how it works :
The user tries to access a resource that is protected (e.g. /admin);
The firewall initiates the authentication process by redirecting the user to the login form (/login);
The /login page renders login form via the route and controller created in this example;
The user submits the login form to /login;
The security system (i.e. the form_login authenticator) intercepts the request, checks the user's submitted credentials, authenticates the user if they are correct, and sends the user back to the login form if they are not.

More information in the [offcial documentation](https://symfony.com/doc/current/security.html#authenticating-users)

# Permissions

To check user’s permissions, I used the voters system, they allow you to centralize all permission logic, then reuse them in many places.

You can use any voter like this in your controller when you need to check permission : 

```php 
 public function delete(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        //stops here if no access
        $this->denyAccessUnlessGranted('delete', $task);
        
        $taskRepository->remove($task);
      
    }
```
How the voter works :
```php 
     private function canView(Task $task, $user): bool
    {
        // if they can edit, they can view || if task has no user, they can view anyway
        if ($this->canEdit($task, $user) || empty($task->getUser())) {
            return true;
        }
        return false;
    }
```
More information in the [offcial documentation](https://symfony.com/doc/current/security/voters.html)