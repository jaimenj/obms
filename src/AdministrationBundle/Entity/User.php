<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Business", mappedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $businesses;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Business", inversedBy="usersCurrentBusiness")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $currentBusiness;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $sessionId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $thirdsEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hhrrEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $shoppingEnabled  = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $storageEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $salesEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accountingEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $productionEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $logisticsEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $planificationEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $processControlEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $documentsEnabled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $intelligenceEnabled = false;

    /**
     * Default constructor.
     */
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
    public function addBusiness(\AppBundle\Entity\Business $business)
    {
        $this->businesses[] = $business;
        $business->addUser($this);

        return $this;
    }

    /**
     * Remove businesses.
     *
     * @param \AppBundle\Entity\Business $businesses
     */
    public function removeBusiness(\AppBundle\Entity\Business $business)
    {
        $this->businesses->removeElement($business);
        $business->removeUser($this);
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
     * Set currentBusiness.
     *
     * @param \AppBundle\Entity\Business $currentBusiness
     *
     * @return User
     */
    public function setCurrentBusiness(\AppBundle\Entity\Business $currentBusiness = null)
    {
        $this->currentBusiness = $currentBusiness;

        return $this;
    }

    /**
     * Get currentBusiness.
     *
     * @return \AppBundle\Entity\Business
     */
    public function getCurrentBusiness()
    {
        return $this->currentBusiness;
    }

    /**
     * Set sessionId.
     *
     * @param string $sessionId
     *
     * @return User
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId.
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set thirdsEnabled.
     *
     * @param bool $thirdsEnabled
     *
     * @return User
     */
    public function setThirdsEnabled($thirdsEnabled)
    {
        $this->thirdsEnabled = $thirdsEnabled;

        return $this;
    }

    /**
     * Get thirdsEnabled.
     *
     * @return bool
     */
    public function getThirdsEnabled()
    {
        return $this->thirdsEnabled;
    }

    /**
     * Set hhrrEnabled.
     *
     * @param bool $hhrrEnabled
     *
     * @return User
     */
    public function setHhrrEnabled($hhrrEnabled)
    {
        $this->hhrrEnabled = $hhrrEnabled;

        return $this;
    }

    /**
     * Get hhrrEnabled.
     *
     * @return bool
     */
    public function getHhrrEnabled()
    {
        return $this->hhrrEnabled;
    }

    /**
     * Set shoppingEnabled.
     *
     * @param bool $shoppingEnabled
     *
     * @return User
     */
    public function setShoppingEnabled($shoppingEnabled)
    {
        $this->shoppingEnabled = $shoppingEnabled;

        return $this;
    }

    /**
     * Get shoppingEnabled.
     *
     * @return bool
     */
    public function getShoppingEnabled()
    {
        return $this->shoppingEnabled;
    }

    /**
     * Set storageEnabled.
     *
     * @param bool $storageEnabled
     *
     * @return User
     */
    public function setStorageEnabled($storageEnabled)
    {
        $this->storageEnabled = $storageEnabled;

        return $this;
    }

    /**
     * Get storageEnabled.
     *
     * @return bool
     */
    public function getStorageEnabled()
    {
        return $this->storageEnabled;
    }

    /**
     * Set salesEnabled.
     *
     * @param bool $salesEnabled
     *
     * @return User
     */
    public function setSalesEnabled($salesEnabled)
    {
        $this->salesEnabled = $salesEnabled;

        return $this;
    }

    /**
     * Get salesEnabled.
     *
     * @return bool
     */
    public function getSalesEnabled()
    {
        return $this->salesEnabled;
    }

    /**
     * Set accountingEnabled.
     *
     * @param bool $accountingEnabled
     *
     * @return User
     */
    public function setAccountingEnabled($accountingEnabled)
    {
        $this->accountingEnabled = $accountingEnabled;

        return $this;
    }

    /**
     * Get accountingEnabled.
     *
     * @return bool
     */
    public function getAccountingEnabled()
    {
        return $this->accountingEnabled;
    }

    /**
     * Set productionEnabled.
     *
     * @param bool $productionEnabled
     *
     * @return User
     */
    public function setProductionEnabled($productionEnabled)
    {
        $this->productionEnabled = $productionEnabled;

        return $this;
    }

    /**
     * Get productionEnabled.
     *
     * @return bool
     */
    public function getProductionEnabled()
    {
        return $this->productionEnabled;
    }

    /**
     * Set logisticsEnabled.
     *
     * @param bool $logisticsEnabled
     *
     * @return User
     */
    public function setLogisticsEnabled($logisticsEnabled)
    {
        $this->logisticsEnabled = $logisticsEnabled;

        return $this;
    }

    /**
     * Get logisticsEnabled.
     *
     * @return bool
     */
    public function getLogisticsEnabled()
    {
        return $this->logisticsEnabled;
    }

    /**
     * Set planificationEnabled.
     *
     * @param bool $planificationEnabled
     *
     * @return User
     */
    public function setPlanificationEnabled($planificationEnabled)
    {
        $this->planificationEnabled = $planificationEnabled;

        return $this;
    }

    /**
     * Get planificationEnabled.
     *
     * @return bool
     */
    public function getPlanificationEnabled()
    {
        return $this->planificationEnabled;
    }

    /**
     * Set processControlEnabled.
     *
     * @param bool $processControlEnabled
     *
     * @return User
     */
    public function setProcessControlEnabled($processControlEnabled)
    {
        $this->processControlEnabled = $processControlEnabled;

        return $this;
    }

    /**
     * Get processControlEnabled.
     *
     * @return bool
     */
    public function getProcessControlEnabled()
    {
        return $this->processControlEnabled;
    }

    /**
     * Set documentsEnabled.
     *
     * @param bool $documentsEnabled
     *
     * @return User
     */
    public function setDocumentsEnabled($documentsEnabled)
    {
        $this->documentsEnabled = $documentsEnabled;

        return $this;
    }

    /**
     * Get documentsEnabled.
     *
     * @return bool
     */
    public function getDocumentsEnabled()
    {
        return $this->documentsEnabled;
    }

    /**
     * Set intelligenceEnabled.
     *
     * @param bool $intelligenceEnabled
     *
     * @return User
     */
    public function setIntelligenceEnabled($intelligenceEnabled)
    {
        $this->intelligenceEnabled = $intelligenceEnabled;

        return $this;
    }

    /**
     * Get intelligenceEnabled.
     *
     * @return bool
     */
    public function getIntelligenceEnabled()
    {
        return $this->intelligenceEnabled;
    }
}
