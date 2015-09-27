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
 * SalesAmendmentInvoice.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SalesAmendmentInvoiceRepository")
 */
class SalesAmendmentInvoice
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
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="salesAmendmentInvoices")
     */
    private $business;

    /**
     * @ORM\OneToOne(targetEntity="SalesInvoice", mappedBy="salesAmendmentInvoice")
     */
    private $salesInvoice;

    /**
     * @ORM\OneToMany(targetEntity="SalesAmendmentInvoiceDetail", mappedBy="salesAmendmentInvoice", cascade="remove")
     */
    private $salesAmendmentInvoiceDetails;

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
     * @return SalesAmendmentInvoice
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
     * @return SalesAmendmentInvoice
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
     * Constructor
     */
    public function __construct()
    {
        $this->salesAmendmentInvoiceDetails = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set business
     *
     * @param \AppBundle\Entity\Business $business
     * @return SalesAmendmentInvoice
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
     * Set salesInvoice
     *
     * @param \AppBundle\Entity\SalesInvoice $salesInvoice
     * @return SalesAmendmentInvoice
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

    /**
     * Add salesAmendmentInvoiceDetails
     *
     * @param \AppBundle\Entity\SalesAmendmentInvoiceDetail $salesAmendmentInvoiceDetails
     * @return SalesAmendmentInvoice
     */
    public function addSalesAmendmentInvoiceDetail(\AppBundle\Entity\SalesAmendmentInvoiceDetail $salesAmendmentInvoiceDetails)
    {
        $this->salesAmendmentInvoiceDetails[] = $salesAmendmentInvoiceDetails;

        return $this;
    }

    /**
     * Remove salesAmendmentInvoiceDetails
     *
     * @param \AppBundle\Entity\SalesAmendmentInvoiceDetail $salesAmendmentInvoiceDetails
     */
    public function removeSalesAmendmentInvoiceDetail(\AppBundle\Entity\SalesAmendmentInvoiceDetail $salesAmendmentInvoiceDetails)
    {
        $this->salesAmendmentInvoiceDetails->removeElement($salesAmendmentInvoiceDetails);
    }

    /**
     * Get salesAmendmentInvoiceDetails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalesAmendmentInvoiceDetails()
    {
        return $this->salesAmendmentInvoiceDetails;
    }
}
