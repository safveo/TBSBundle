<?php

namespace Time\TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Tbs_Managers
 *
 * @ORM\Table(name="tbs_manager")
 * @ORM\Entity(repositoryClass="Time\TBSBundle\Repository\TbsManagersRepository")
 */
class TbsManagers
{
    use ORMBehaviors\Blameable\Blameable,
        ORMBehaviors\Timestampable\Timestampable;
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer")
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
     * Set active
     *
     * @param integer $active
     *
     * @return TbsManagers
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
     * @ORM\ManyToOne(targetEntity="Time\TBSBundle\Entity\TbsPole", cascade={"persist"} )
     *@ORM\JoinColumn(name="tbs_pole_id", referencedColumnName="id")
     */
    private $tbs_pole;
    /**
     * @ORM\ManyToOne(targetEntity="Time\TBSBundle\Entity\TbsUser", cascade={"persist"} )
     *@ORM\JoinColumn(name="tbs_user_id", referencedColumnName="id")
     */
    private $tbs_User;

    /**
     * @return mixed
     */
    public function getTbsPole()
    {
        return $this->tbs_pole;
    }

    /**
     * @param mixed $tbs_pole
     */
    public function setTbsPole($tbs_pole)
    {
        $this->tbs_pole = $tbs_pole;
    }

    /**
     * @return mixed
     */
    public function getTbsUser()
    {
        return $this->tbs_User;
    }

    /**
     * @param mixed $tbs_User
     */
    public function setTbsUser($tbs_User)
    {
        $this->tbs_User = $tbs_User;
    }

    public function __toString()
    {
       return $this->getTbsUser()->getUser()->getDisplayName();
    }


}

