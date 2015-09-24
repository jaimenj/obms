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
 * SalesNote.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SalesNoteRepository")
 */
class SalesNote
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
    private $reference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="salesNotes")
     */
    private $business;

    /**
     * @ORM\OneToMany(targetEntity="SalesNoteDetail", mappedBy="salesNote", cascade="remove")
     */
    private $salesNoteDetails;

    /**
     * @ORM\ManyToOne(targetEntity="SalesBudget", inversedBy="salesNotes")
     */
    private $salesBudget;

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
     * Set reference
     *
     * @param string $reference
     * @return SalesNote
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return SalesNote
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return SalesNote
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salesNoteDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set business
     *
     * @param \AppBundle\Entity\Business $business
     * @return SalesNote
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

    /**
     * Add salesNoteDetails
     *
     * @param \AppBundle\Entity\SalesNoteDetail $salesNoteDetails
     * @return SalesNote
     */
    public function addSalesNoteDetail(\AppBundle\Entity\SalesNoteDetail $salesNoteDetails)
    {
        $this->salesNoteDetails[] = $salesNoteDetails;

        return $this;
    }

    /**
     * Remove salesNoteDetails
     *
     * @param \AppBundle\Entity\SalesNoteDetail $salesNoteDetails
     */
    public function removeSalesNoteDetail(\AppBundle\Entity\SalesNoteDetail $salesNoteDetails)
    {
        $this->salesNoteDetails->removeElement($salesNoteDetails);
    }

    /**
     * Get salesNoteDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalesNoteDetails()
    {
        return $this->salesNoteDetails;
    }

    /**
     * Set salesBudget
     *
     * @param \AppBundle\Entity\SalesBudget $salesBudget
     * @return SalesNote
     */
    public function setSalesBudget(\AppBundle\Entity\SalesBudget $salesBudget = null)
    {
        $this->salesBudget = $salesBudget;

        return $this;
    }

    /**
     * Get salesBudget
     *
     * @return \AppBundle\Entity\SalesBudget 
     */
    public function getSalesBudget()
    {
        return $this->salesBudget;
    }
}
