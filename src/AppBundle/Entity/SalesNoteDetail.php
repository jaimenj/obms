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
 * SalesNoteDetail
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SalesNoteDetailRepository")
 */
class SalesNoteDetail
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
    private $concept;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="SalesNote", inversedBy="salesNoteDetails")
     */
    private $salesNote;

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
     * @return SalesNoteDetail
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
     * @return SalesNoteDetail
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
     * @return SalesNoteDetail
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
     * Set salesNote
     *
     * @param \AppBundle\Entity\SalesNote $salesNote
     * @return SalesNoteDetail
     */
    public function setSalesNote(\AppBundle\Entity\SalesNote $salesNote = null)
    {
        $this->salesNote = $salesNote;

        return $this;
    }

    /**
     * Get salesNote
     *
     * @return \AppBundle\Entity\SalesNote 
     */
    public function getSalesNote()
    {
        return $this->salesNote;
    }
}
