<?php

namespace Time\TBSBundle\Entity;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tbs_Service
 *
 * @ORM\Table(name="tbs_service")
 * @ORM\Entity(repositoryClass="Time\TBSBundle\Repository\TbsServiceRepository")
 */
class TbsService
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
     *
     * @ORM\Column(name="active", type="binary")
     */
    private $active;


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
     * @return Tbs_Service
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
     * @return Tbs_Service
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

    public function __toString()
    {
        return $this->getName();
    }

}

