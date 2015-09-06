<?php

namespace AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User, entity for managing user accounts that can access to the hole app system.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AdministrationBundle\Entity\UserRepository")
 * @UniqueEntity("email", message="Other user has the same email.")
 */
class User extends BaseUser
{
    /**
     * @var int @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /*protected $username;

    protected $email;
*/

    /**
     * Constructor of the class.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The string operator.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nombre;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add roles.
     *
     * @param \AdministrationBundle\Entity\Role $roles
     *
     * @return User
     */
    public function addRole($role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove roles.
     *
     * @param \AdministrationBundle\Entity\Role $roles
     */
    public function removeRole($role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
