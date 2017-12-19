<?php

namespace Time\TBSBundle\Entity;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tbs_Poste
 *
 * @ORM\Table(name="tbs_poste")
 * @ORM\Entity(repositoryClass="Time\TBSBundle\Repository\TbsPosteRepository")
 */
class TbsPoste
{
    use ORMBehaviors\Blameable\Blameable,
        ORMBehaviors\Timestampable\Timestampable;
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="hourly_rate", type="decimal")
     */
    private $hourlyRate;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="Time\TBSBundle\Entity\TbsService", cascade={"persist"} )
     *@ORM\JoinColumn(name="tbs_service_id", referencedColumnName="id")
     */
    private $tbs_service;
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
     * Set name
     *
     * @param string $name
     *
     * @return Tbs_Poste
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set hourlyRate
     *
     * @param string $hourlyRate
     *
     * @return Tbs_Poste
     */
    public function setHourlyRate($hourlyRate)
    {
        $this->hourlyRate = $hourlyRate;

        return $this;
    }

    /**
     * Get hourlyRate
     *
     * @return string
     */
    public function getHourlyRate()
    {
        return $this->hourlyRate;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Tbs_Poste
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return mixed
     */
    public function getTbsService()
    {
        return $this->tbs_service;
    }

    /**
     * @param mixed $tbs_service
     */
    public function setTbsService($tbs_service)
    {
        $this->tbs_service = $tbs_service;
    }
    public function __toString()
    {
        return $this->getName();
    }
}

