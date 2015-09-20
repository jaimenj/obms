<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkerPayroll.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\WorkerPayrollRepository")
 */
class WorkerPayroll
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $month;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Worker", inversedBy="workerPayrolls")
     */
    private $worker;

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
     * Set year.
     *
     * @param int $year
     *
     * @return WorkerPayroll
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year.
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month.
     *
     * @param int $month
     *
     * @return WorkerPayroll
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month.
     *
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set amount.
     *
     * @param string $amount
     *
     * @return WorkerPayroll
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set worker.
     *
     * @param \AppBundle\Entity\Worker $worker
     *
     * @return WorkerPayroll
     */
    public function setWorker(\AppBundle\Entity\Worker $worker = null)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get worker.
     *
     * @return \AppBundle\Entity\Worker
     */
    public function getWorker()
    {
        return $this->worker;
    }
}
