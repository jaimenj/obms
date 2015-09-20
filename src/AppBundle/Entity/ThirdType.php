<?php

/**
 * This file is part of The OBMS project: https://github.com/obms/obms
 *
 * Copyright (c) Jaime Niñoles-Manzanera Jimeno.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThirdType.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ThirdTypeRepository")
 */
class ThirdType
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Third", mappedBy="thirdType")
     */
    private $thirds;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="thirdtypes")
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
     * Set name.
     *
     * @param string $name
     *
     * @return ThirdType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->thirds = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add thirds.
     *
     * @param \AppBundle\Entity\Third $thirds
     *
     * @return ThirdType
     */
    public function addThird(\AppBundle\Entity\Third $thirds)
    {
        $this->thirds[] = $thirds;

        return $this;
    }

    /**
     * Remove thirds.
     *
     * @param \AppBundle\Entity\Third $thirds
     */
    public function removeThird(\AppBundle\Entity\Third $thirds)
    {
        $this->thirds->removeElement($thirds);
    }

    /**
     * Get thirds.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThirds()
    {
        return $this->thirds;
    }

    /**
     * String operator.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set business
     *
     * @param \AppBundle\Entity\Business $business
     * @return ThirdType
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
