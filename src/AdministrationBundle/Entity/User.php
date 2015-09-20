<?php

namespace AdministrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User, entity for managing user accounts that can access to the hole app system.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AdministrationBundle\Entity\UserRepository")
 * @UniqueEntity("email", message="Other user has the same email.")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var int @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnabled = false;

    /**
     * @ORM\Column(type="string")
     */
    private $salt;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Business", mappedBy="users")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $businesses;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Business", inversedBy="usersCurrentBusiness")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $currentBusiness;

    /**
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $sessionId;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * The string operator.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->username;
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
     * Set username.
     *
     * @param string $username
     *
     * @return Administrador
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Administrador
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return Administrador
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array(
            'ROLE_USER',
        );
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * Set salt.
     *
     * @param string $salt
     *
     * @return Administrador
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isEnabled.
     *
     * @param bool $isEnabled
     *
     * @return User
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get isEnabled.
     *
     * @return bool
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Add businesses.
     *
     * @param \AppBundle\Entity\Business $businesses
     *
     * @return User
     */
    public function addBusiness(\AppBundle\Entity\Business $businesses)
    {
        $this->businesses[] = $businesses;

        return $this;
    }

    /**
     * Remove businesses.
     *
     * @param \AppBundle\Entity\Business $businesses
     */
    public function removeBusiness(\AppBundle\Entity\Business $businesses)
    {
        $this->businesses->removeElement($businesses);
    }

    /**
     * Get businesses.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBusinesses()
    {
        return $this->businesses;
    }

    /**
     * Set currentBusiness
     *
     * @param \AppBundle\Entity\Business $currentBusiness
     * @return User
     */
    public function setCurrentBusiness(\AppBundle\Entity\Business $currentBusiness = null)
    {
        $this->currentBusiness = $currentBusiness;

        return $this;
    }

    /**
     * Get currentBusiness
     *
     * @return \AppBundle\Entity\Business
     */
    public function getCurrentBusiness()
    {
        return $this->currentBusiness;
    }

    /**
     * Set sessionId
     *
     * @param string $sessionId
     * @return User
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }
}
