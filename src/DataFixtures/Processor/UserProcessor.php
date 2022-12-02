<?php

namespace App\DataFixtures\Processor;

use App\Entity\User;
use Fidry\AliceDataFixtures\ProcessorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserProcessor implements ProcessorInterface
{
    private $passwordHasher;

    public function __construct(private UserPasswordHasherInterface $passwordHashe)
    {
        $this->passwordHasher = $passwordHashe;
    }

    public function preProcess(string $fixture, object $object): void
    {
        if (false === $object instanceof User) {
          return;
        }

        $object->setPassword($this->passwordHasher->hashPassword($object, $object->getPassword()));
    }

    public function postProcess(string $fixture, object $object): void
    {

    }
}
