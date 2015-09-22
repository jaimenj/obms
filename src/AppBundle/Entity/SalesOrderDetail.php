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
 * SalesOrderDetail
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SalesOrderDetailRepository")
 */
class SalesOrderDetail
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
     * @return SalesOrderDetail
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
     * @return SalesOrderDetail
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
     * @return SalesOrderDetail
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
}
