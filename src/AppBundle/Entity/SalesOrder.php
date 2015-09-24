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
 * SalesOrder.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SalesOrderRepository")
 */
class SalesOrder
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
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="salesOrders")
     */
    private $business;

    /**
     * @ORM\OneToMany(targetEntity="SalesOrderDetail", mappedBy="salesOrder", cascade="remove")
     */
    private $salesOrderDetails;

    /**
     * @ORM\ManyToOne(targetEntity="SalesBudget", inversedBy="salesOrders")
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
     * Set reference.
     *
     * @param string $reference
     *
     * @return SalesOrder
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return SalesOrder
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return SalesOrder
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
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
        $this->salesOrderDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set business
     *
     * @param \AppBundle\Entity\Business $business
     * @return SalesOrder
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
     * Add salesOrderDetails
     *
     * @param \AppBundle\Entity\SalesOrderDetail $salesOrderDetails
     * @return SalesOrder
     */
    public function addSalesOrderDetail(\AppBundle\Entity\SalesOrderDetail $salesOrderDetails)
    {
        $this->salesOrderDetails[] = $salesOrderDetails;

        return $this;
    }

    /**
     * Remove salesOrderDetails
     *
     * @param \AppBundle\Entity\SalesOrderDetail $salesOrderDetails
     */
    public function removeSalesOrderDetail(\AppBundle\Entity\SalesOrderDetail $salesOrderDetails)
    {
        $this->salesOrderDetails->removeElement($salesOrderDetails);
    }

    /**
     * Get salesOrderDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalesOrderDetails()
    {
        return $this->salesOrderDetails;
    }

    /**
     * Set salesBudget
     *
     * @param \AppBundle\Entity\SalesBudget $salesBudget
     * @return SalesOrder
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
