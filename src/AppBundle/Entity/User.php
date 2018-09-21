<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Entity()
* @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="users_email_unique",columns={"email"})})
*/
class User implements UserInterface
{
   /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $fullname;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="Operation", mappedBy="user")
     */
    protected $operations;

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    protected $plainPassword;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPlainPassword()
    {
      return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
      $this->plainPassword = $password;
    }

    public function getPassword()
    {
      return $this->password;
    }

    public function setPassword($password)
    {
      $this->password = $password;
    }
    public function getRoles()
    {
      return [];
    }

    public function getSalt()
    {
      return null;
    }
    public function getUsername()
    {
      return $this->email;
    }

    public function eraseCredentials()
    {
      // Suppression des données sensibles
      $this->plainPassword = null;
    }
}