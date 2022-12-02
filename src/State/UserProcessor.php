<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProcessor implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $entityManager , private UserPasswordHasherInterface $passwordHasher)
    {
    
    }
    
    
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        // Handle the state
        if($data instanceof User === false){
           return;
        } 

        $data->setPassword($this->passwordHasher->hashPassword($data, $data->getPassword()));

        if( $operation->getName() === "_api_/users{._format}_post"){
            $data->setCreatedAt(new \DateTimeImmutable());
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}




