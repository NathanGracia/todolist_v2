<?php

namespace App\Tests;

use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Faker\Factory as Faker;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionUnionType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class EntityGetSetTest extends WebTestCase
{
    /**
     * @var array|string[]
     */
    private static $entities;

    private static $ignore = [
        User::class => [
            "roles" => ['get']
        ]
    ];
    
    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $em = $container->get('doctrine')->getManager();
        $meta = $em->getMetadataFactory()->getAllMetadata();
        self::$entities = array_map(function (ClassMetadata $metadata) {
            return $metadata->getName();
        }, $meta);
    }

    public function testGetters(): void
    {
        foreach (self::$entities as $entityFullName) {
            $entityReflection = new ReflectionClass($entityFullName);

            $entity = new $entityFullName();

            foreach ($entityReflection->getProperties() as $reflectionProperty) {
                $propertyValue = $this->getFakeValue($reflectionProperty->getType());
                $propertyName = $reflectionProperty->getName();
                if( isset(self::$ignore[$entityFullName]) && isset(self::$ignore[$entityFullName][$propertyName]) && in_array("get", self::$ignore[$entityFullName][$propertyName], true)){
                    continue;
                }

                $reflectionProperty->setValue($entity, $propertyValue);

                $getterName = 'get' . ucfirst($propertyName);

                if (!$entityReflection->hasMethod($getterName)) {
                    continue;
                }

                self::assertEquals($propertyValue, $entity->$getterName());
            }
        }
    }

    public function testSetters(): void
    {
        foreach (self::$entities as $entityFullName) {
            $entityReflection = new ReflectionClass($entityFullName);

            $entity = new $entityFullName();

            foreach ($entityReflection->getProperties() as $reflectionProperty) {
                $propertyValue = $this->getFakeValue($reflectionProperty->getType());
                $propertyName = $reflectionProperty->getName();
                if( isset(self::$ignore[$entityFullName]) && isset(self::$ignore[$entityFullName][$propertyName]) && in_array("set", self::$ignore[$entityFullName][$propertyName], true)){
                    continue;
                }
                $setterName = 'set' . ucfirst($propertyName);

                if (!$entityReflection->hasMethod($setterName)) {
                    continue;
                }

                $entity->$setterName($propertyValue);

                self::assertEquals($propertyValue, $reflectionProperty->getValue($entity));
            }
        }
    }

    private function getFakeValue( $reflectionType)
    {
        if ($reflectionType instanceof ReflectionUnionType) {
            $typeName = $reflectionType->getTypes()[0]->getName();
        } elseif ($reflectionType instanceof ReflectionNamedType) {
            $typeName = $reflectionType->getName();
        } else {
            return null;
        }

        $faker = Faker::create();
        switch ($typeName) {
            case 'string':
                $paramValue = 'aaa';
                break;
            case 'int':
                $paramValue = 10;
                break;
            case 'bool':
                $paramValue = True;
                break;
            case 'DateTimeImmutable':
                $paramValue =  new \DateTimeImmutable('2000-01-01');
                break;
            case 'array':
                $paramValue =  [];
                break;
            case Collection::class:
                $paramValue =  new ArrayCollection();
                break;
            default :
                $paramValue =  new $typeName();
                break;
        }
        return $paramValue;
    }
}
