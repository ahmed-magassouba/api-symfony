<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\UserProcessor;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]

#[ApiResource(

    operations: [
         new GetCollection(
            normalizationContext: ['groups' => ['user:getCollection:read']],
            denormalizationContext: ['groups' => ['user:post:write']],
         ),

         new Post(
           normalizationContext: ['groups' => ['user:post:read']],
           denormalizationContext: ['groups' => ['user:post:write']],
            processor: UserProcessor::class,
            // security: 'is_granted("ROLE_ADMIN")',
            // securityMessage: 'Only admins can access this resource',
            // securityPostDenormalize: 'is_granted("ROLE_ADMIN")',
            // securityPostDenormalizeMessage: 'Only admins can access this resource',
            // securityPostValidationMessage: 'Only admins can access this resource',
            // securityPostValidation: 'is_granted("ROLE_ADMIN")',
         ),

         new Get(normalizationContext: ['groups' => ['user:get:read']],

         ),

         new Put(),

         new Patch(),

         new Delete(),

    ],


)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user:post:write','user:get:read'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:post:write'])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:post:write','user:getCollection:read','groupe:getCollection:read','user:get:read'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user:post:write','user:getCollection:read','groupe:getCollection:read','user:get:read'])]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[Groups(['user:post:write','user:get:read'])]
    private ?Groupe $groupe = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;




    public function __construct()
    {
 
    }






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getGroupe(): ?groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }



}
