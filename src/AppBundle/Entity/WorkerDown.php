<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WorkerDown.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\WorkerDownRepository")
 */
class WorkerDown
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
     * @ORM\ManyToOne(targetEntity="Worker", inversedBy="workerDowns")
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
     * @return WorkerDown
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
     * @return WorkerDown
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
}