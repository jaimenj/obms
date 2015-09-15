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
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="workers")
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workerDowns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->workerHollidays = new \Doctrine\Common\Collections\ArrayCollection();
        $this->workerPayrolls = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add workerDowns
     *
     * @param \AppBundle\Entity\WorkerDown $workerDowns
     * @return Worker
     */
    public function addWorkerDown(\AppBundle\Entity\WorkerDown $workerDowns)
    {
        $this->workerDowns[] = $workerDowns;

        return $this;
    }

    /**
     * Remove workerDowns
     *
     * @param \AppBundle\Entity\WorkerDown $workerDowns
     */
    public function removeWorkerDown(\AppBundle\Entity\WorkerDown $workerDowns)
    {
        $this->workerDowns->removeElement($workerDowns);
    }

    /**
     * Get workerDowns
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkerDowns()
    {
        return $this->workerDowns;
    }

    /**
     * Add workerHollidays
     *
     * @param \AppBundle\Entity\WorkerHolliday $workerHollidays
     * @return Worker
     */
    public function addWorkerHolliday(\AppBundle\Entity\WorkerHolliday $workerHollidays)
    {
        $this->workerHollidays[] = $workerHollidays;

        return $this;
    }

    /**
     * Remove workerHollidays
     *
     * @param \AppBundle\Entity\WorkerHolliday $workerHollidays
     */
    public function removeWorkerHolliday(\AppBundle\Entity\WorkerHolliday $workerHollidays)
    {
        $this->workerHollidays->removeElement($workerHollidays);
    }

    /**
     * Get workerHollidays
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkerHollidays()
    {
        return $this->workerHollidays;
    }

    /**
     * Add workerPayrolls
     *
     * @param \AppBundle\Entity\WorkerPayroll $workerPayrolls
     * @return Worker
     */
    public function addWorkerPayroll(\AppBundle\Entity\WorkerPayroll $workerPayrolls)
    {
        $this->workerPayrolls[] = $workerPayrolls;

        return $this;
    }

    /**
     * Remove workerPayrolls
     *
     * @param \AppBundle\Entity\WorkerPayroll $workerPayrolls
     */
    public function removeWorkerPayroll(\AppBundle\Entity\WorkerPayroll $workerPayrolls)
    {
        $this->workerPayrolls->removeElement($workerPayrolls);
    }

    /**
     * Get workerPayrolls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkerPayrolls()
    {
        return $this->workerPayrolls;
    }

    /**
     * Set business
     *
     * @param \AppBundle\Entity\Business $business
     * @return Worker
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
