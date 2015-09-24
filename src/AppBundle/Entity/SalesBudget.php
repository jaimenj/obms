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
 * SalesBudget
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SalesBudgetRepository")
 */
class SalesBudget
{
    /**
     * @var integer
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
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="salesBudgets")
     */
    private $business;

    /**
     * @ORM\OneToMany(targetEntity="SalesBudgetDetail", mappedBy="salesBudget", cascade="remove")
     */
    private $salesBudgetDetails;

    /**
     * @ORM\OneToMany(targetEntity="SalesNote", mappedBy="salesBudget", cascade="remove")
     */
    private $salesNotes;

    /**
     * @ORM\OneToMany(targetEntity="SalesOrder", mappedBy="salesBudget", cascade="remove")
     */
    private $salesOrders;

    /**
     * @ORM\OneToOne(targetEntity="SalesPreinvoice", inversedBy="salesBudget")
     */
    private $salesPreinvoice;

    /**
     * @ORM\OneToOne(targetEntity="SalesInvoice", inversedBy="salesBudget")
     */
    private $salesInvoice;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return SalesBudget
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
     * @return SalesBudget
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
     * @return SalesBudget
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
        $this->salesBudgetDetails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salesNotes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->salesOrders = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set business
     *
     * @param \AppBundle\Entity\Business $business
     * @return SalesBudget
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
     * Add salesBudgetDetails
     *
     * @param \AppBundle\Entity\SalesBudgetDetail $salesBudgetDetails
     * @return SalesBudget
     */
    public function addSalesBudgetDetail(\AppBundle\Entity\SalesBudgetDetail $salesBudgetDetails)
    {
        $this->salesBudgetDetails[] = $salesBudgetDetails;

        return $this;
    }

    /**
     * Remove salesBudgetDetails
     *
     * @param \AppBundle\Entity\SalesBudgetDetail $salesBudgetDetails
     */
    public function removeSalesBudgetDetail(\AppBundle\Entity\SalesBudgetDetail $salesBudgetDetails)
    {
        $this->salesBudgetDetails->removeElement($salesBudgetDetails);
    }

    /**
     * Get salesBudgetDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalesBudgetDetails()
    {
        return $this->salesBudgetDetails;
    }

    /**
     * Add salesNotes
     *
     * @param \AppBundle\Entity\SalesNote $salesNotes
     * @return SalesBudget
     */
    public function addSalesNote(\AppBundle\Entity\SalesNote $salesNotes)
    {
        $this->salesNotes[] = $salesNotes;

        return $this;
    }

    /**
     * Remove salesNotes
     *
     * @param \AppBundle\Entity\SalesNote $salesNotes
     */
    public function removeSalesNote(\AppBundle\Entity\SalesNote $salesNotes)
    {
        $this->salesNotes->removeElement($salesNotes);
    }

    /**
     * Get salesNotes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalesNotes()
    {
        return $this->salesNotes;
    }

    /**
     * Add salesOrders
     *
     * @param \AppBundle\Entity\SalesOrder $salesOrders
     * @return SalesBudget
     */
    public function addSalesOrder(\AppBundle\Entity\SalesOrder $salesOrders)
    {
        $this->salesOrders[] = $salesOrders;

        return $this;
    }

    /**
     * Remove salesOrders
     *
     * @param \AppBundle\Entity\SalesOrder $salesOrders
     */
    public function removeSalesOrder(\AppBundle\Entity\SalesOrder $salesOrders)
    {
        $this->salesOrders->removeElement($salesOrders);
    }

    /**
     * Get salesOrders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalesOrders()
    {
        return $this->salesOrders;
    }

    /**
     * Set salesPreinvoice
     *
     * @param \AppBundle\Entity\SalesPreinvoice $salesPreinvoice
     * @return SalesBudget
     */
    public function setSalesPreinvoice(\AppBundle\Entity\SalesPreinvoice $salesPreinvoice = null)
    {
        $this->salesPreinvoice = $salesPreinvoice;

        return $this;
    }

    /**
     * Get salesPreinvoice
     *
     * @return \AppBundle\Entity\SalesPreinvoice 
     */
    public function getSalesPreinvoice()
    {
        return $this->salesPreinvoice;
    }

    /**
     * Set salesInvoice
     *
     * @param \AppBundle\Entity\SalesInvoice $salesInvoice
     * @return SalesBudget
     */
    public function setSalesInvoice(\AppBundle\Entity\SalesInvoice $salesInvoice = null)
    {
        $this->salesInvoice = $salesInvoice;

        return $this;
    }

    /**
     * Get salesInvoice
     *
     * @return \AppBundle\Entity\SalesInvoice 
     */
    public function getSalesInvoice()
    {
        return $this->salesInvoice;
    }
}
