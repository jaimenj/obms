<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkerHolliday.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\WorkerHollidayRepository")
 */
class WorkerHolliday
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
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $initdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $finishdate;

    /**
     * @ORM\ManyToOne(targetEntity="Worker", inversedBy="workerHollidays")
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
     * Set initdate.
     *
     * @param \DateTime $initdate
     *
     * @return WorkerHolliday
     */
    public function setInitdate($initdate)
    {
        $this->initdate = $initdate;

        return $this;
    }

    /**
     * Get initdate.
     *
     * @return \DateTime
     */
    public function getInitdate()
    {
        return $this->initdate;
    }

    /**
     * Set finishdate.
     *
     * @param \DateTime $finishdate
     *
     * @return WorkerHolliday
     */
    public function setFinishdate($finishdate)
    {
        $this->finishdate = $finishdate;

        return $this;
    }

    /**
     * Get finishdate.
     *
     * @return \DateTime
     */
    public function getFinishdate()
    {
        return $this->finishdate;
    }

    /**
     * Set worker
     *
     * @param \AppBundle\Entity\Worker $worker
     * @return WorkerHolliday
     */
    public function setWorker(\AppBundle\Entity\Worker $worker = null)
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Get worker
     *
     * @return \AppBundle\Entity\Worker 
     */
    public function getWorker()
    {
        return $this->worker;
    }
}
