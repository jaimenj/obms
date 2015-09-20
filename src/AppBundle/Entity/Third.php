<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Third.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ThirdRepository")
 */
class Third
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $web;

    /**
     * @ORM\ManyToOne(targetEntity="ThirdType", inversedBy="thirds")
     */
    private $thirdType;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="thirds")
     */
    private $business;

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
     * Set fullname.
     *
     * @param string $fullname
     *
     * @return Third
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname.
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set telephone.
     *
     * @param string $telephone
     *
     * @return Third
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set address.
     *
     * @param string $address
     *
     * @return Third
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Third
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
     * Set web.
     *
     * @param string $web
     *
     * @return Third
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web.
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set thirdType
     *
     * @param \AppBundle\Entity\ThirdType $thirdType
     * @return Third
     */
    public function setThirdType(\AppBundle\Entity\ThirdType $thirdType = null)
    {
        $this->thirdType = $thirdType;

        return $this;
    }

    /**
     * Get thirdType
     *
     * @return \AppBundle\Entity\ThirdType
     */
    public function getThirdType()
    {
        return $this->thirdType;
    }

    /**
     * Set business
     *
     * @param \AppBundle\Entity\Business $business
     * @return Third
     */
    public function setBusiness(\AppBundle\Entity\Business $business = null)
    {
        $this->business = $business;

        return $this;
    }

    /**
     * Get business
     *
     * @return \AppBundle\Entity\Business 
     */
    public function getBusiness()
    {
        return $this->business;
    }
}
