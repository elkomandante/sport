<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"username"},
 *     message="Username is taken."
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"user:list", "user:single"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Groups({"user:list","user:single"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * @Groups ({"user:single"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=6 ,
     *     minMessage="Password has to contain at least 6 Characters"
     * )
     */
    private $password;


    /**
     * @ORM\Column (type="string", length=1000, nullable=true)
     * @Groups ({"user:single"})
     * @CustomAssert\UserRoleConstraint(role="ROLE_SUPER_USER")
     */
    private $about;


    /**
     * @ORM\Column (type="string", length=255, nullable=true)
     * @Groups ({"user:single"})
     */
    private $linkedinUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param mixed $about
     */
    public function setAbout($about): void
    {
        $this->about = $about;
    }

    /**
     * @return mixed
     */
    public function getLinkedinUrl()
    {
        return $this->linkedinUrl;
    }

    /**
     * @param mixed $linkedinUrl
     */
    public function setLinkedinUrl($linkedinUrl): void
    {
        $this->linkedinUrl = $linkedinUrl;
    }
}
