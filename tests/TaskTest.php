<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Task;

use App\Entity\User;



class TaskTest extends TestCase
{
    public function testGetterSetters(): void
    {
        
        $exceptions = [
            'id'
        ];
        $task = new Task();
        $reflectionTask = new \ReflectionClass(Task::class);
        $properties = $reflectionTask->getProperties();
        foreach ($properties as $property) {
            if (!in_array($property->getName(), $exceptions)) {
                $paramValue = null;
                $setter = $reflectionTask->getMethod('set' . ucfirst($property->getName()));
                $getter = $reflectionTask->getMethod('get' . ucfirst($property->getName()));
                //find good value for parameter
                $param = $setter->getParameters()[0];
                $paramType = $param->getType()->getName();
                switch ($paramType) {
                    case 'string':
                        $paramValue = 'aaa';
                        break;
                    case 'bool':
                        $paramValue = True;
                        break;
                    case 'App\Entity\User':
                        $paramValue = new User();
                        break;
                    case 'DateTimeImmutable':
                        $paramValue =  new \DateTimeImmutable('2000-01-01');
                        break;
                }
                //set value
             
                $setter->invokeArgs($task, array($paramValue));

                //get value
                $this->assertEquals($getter->invokeArgs($task, array()), $paramValue);
            }
        }
        
    }
}
