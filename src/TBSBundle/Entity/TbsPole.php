<?php

namespace Time\TBSBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tbs_Pole
 *
 * @ORM\Table(name="tbs_pole")
 * @ORM\Entity(repositoryClass="Time\TBSBundle\Repository\TbsPoleRepository")
 */
class TbsPole
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
    private $manager ;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tbs_Pole
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
     * Set active
     *
     * @param binary $active
     *
     * @return Tbs_Pole
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return binary
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

    /**
     * @return mixed
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param mixed $manager
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }


}

