<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Worker.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\WorkerRepository")
 */
class Worker
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
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="WorkerDown", mappedBy="worker")
     */
    private $workerDowns;

    /**
     * @ORM\OneToMany(targetEntity="WorkerHolliday", mappedBy="worker")
     */
    private $workerHollidays;

    /**
     * @ORM\OneToMany(targetEntity="WorkerPayroll", mappedBy="worker")
     */
    private $workerPayrolls;

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
     * @return Worker
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
     * @return Worker
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
     * Set email.
     *
     * @param string $email
     *
     * @return Worker
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
}
