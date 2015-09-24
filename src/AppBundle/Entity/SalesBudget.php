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
     * @ORM\OneToMany(targetEntity="SalesNoteDetail", mappedBy="salesBudget", cascade="remove")
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
}
