<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
          fields={"email"},
          message= "L'email que vous avez indiqué est déja choisi"
          )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Veuillez saisir un email correct")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Le mot de passe doit etre supérieur ou égale à 8 caractére")
      * @Assert\EqualTo(propertyPath="confirm_password")
     */
    private $password;

   /**
    *@Assert\EqualTo(propertyPath="password",message="Vous n'avez pas tapez le meme mot de passe")
   */
    public $confirm_password;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(){

        return ['ROLE_USER'];
    }

    public function getSalt(){}

    public function eraseCredentials(){}
}
