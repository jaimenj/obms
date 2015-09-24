<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalesAmendmentInvoiceDetail
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SalesAmendmentInvoiceDetailRepository")
 */
class SalesAmendmentInvoiceDetail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="concept", type="string", length=255)
     */
    private $concept;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="salesAmendmentInvoice", inversedBy="salesAmendmentInvoiceDetails")
     */
    private $salesAmendmentInvoice;

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
     * Set concept
     *
     * @param string $concept
     * @return SalesAmendmentInvoiceDetail
     */
    public function setConcept($concept)
    {
        $this->concept = $concept;

        return $this;
    }

    /**
     * Get concept
     *
     * @return string
     */
    public function getConcept()
    {
        return $this->concept;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return SalesAmendmentInvoiceDetail
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     * @return SalesAmendmentInvoiceDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set salesAmendmentInvoice
     *
     * @param \AppBundle\Entity\salesAmendmentInvoice $salesAmendmentInvoice
     * @return SalesAmendmentInvoiceDetail
     */
    public function setSalesAmendmentInvoice(\AppBundle\Entity\salesAmendmentInvoice $salesAmendmentInvoice = null)
    {
        $this->salesAmendmentInvoice = $salesAmendmentInvoice;

        return $this;
    }

    /**
     * Get salesAmendmentInvoice
     *
     * @return \AppBundle\Entity\salesAmendmentInvoice 
     */
    public function getSalesAmendmentInvoice()
    {
        return $this->salesAmendmentInvoice;
    }
}
