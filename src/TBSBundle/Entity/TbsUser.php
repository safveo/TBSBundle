<?php

namespace Time\TBSBundle\Entity;
use DateTime;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tbs_User
 *
 * @ORM\Table(name="tbs_user")
 * @ORM\Entity(repositoryClass="Time\TBSBundle\Repository\TbsUserRepository")
 */
class TbsUser
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
     * @var \DateTime
     *
     * @ORM\Column(name="weekly_working_hours", type="time")
     */
    private $weeklyWorkingHours;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="period", type="date")
     */
    private $period;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacity_percent", type="integer")
     */
    private $capacityPercent;

    /**
     * @ORM\ManyToOne(targetEntity="Time\TBSBundle\Entity\TbsService", cascade={"persist"} )
     *@ORM\JoinColumn(name="tbs_service_id", referencedColumnName="id")
     */
    private $tbs_service;

    /**
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\User", cascade={"persist"} )
     *@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity="Time\TBSBundle\Entity\TbsPole", cascade={"persist"} )
     *@ORM\JoinColumn(name="tbs_pole_id", referencedColumnName="id")
     */
    private $tbs_pole;
    /**
     * @ORM\ManyToOne(targetEntity="Time\TBSBundle\Entity\TbsPoste", cascade={"persist"} )
     *@ORM\JoinColumn(name="tbs_poste_id", referencedColumnName="id")
     */
    private $tbs_poste;
     private $taux;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    private $pays;
    /**
     * Set weeklyWorkingHours
     *
     * @param \DateTime $weeklyWorkingHours
     *
     * @return TBS_USER
     */
    public function setWeeklyWorkingHours($weeklyWorkingHours)
    {
        $this->weeklyWorkingHours = $weeklyWorkingHours;

        return $this;
    }

    /**
     * Get weeklyWorkingHours
     *
     */
    public function getWeeklyWorkingHours()
    {
        /**
         * Intialisation of the first date
         */
        $date_first = new DateTime('1970-01-01');
        $diff = $date_first->diff($this->weeklyWorkingHours);
        $hours = $diff->h;
        $hours = $hours + ($diff->days*24);
        return $hours;
    }

    /**
     * Set period
     *
     * @param \DateTime $period
     *
     * @return TBS_USER
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return \DateTime
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set capacityPercent
     *
     * @param integer $capacityPercent
     *
     * @return TBS_USER
     */
    public function setCapacityPercent($capacityPercent)
    {
        $this->capacityPercent = $capacityPercent;

        return $this;
    }

    /**
     * Get capacityPercent
     *
     * @return integer
     */
    public function getCapacityPercent()
    {
        return $this->capacityPercent;
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
    public function getTbsPoste()
    {
        return $this->tbs_poste;
    }

    /**
     * @param mixed $tbs_poste
     */
    public function setTbsPoste($tbs_poste)
    {
        $this->tbs_poste = $tbs_poste;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPays()
    {
        return $this->user->getCountryWorking();
    }

    /**
     * @param mixed $pays
     */
    public function setPays($pays)
    {
        $this->user->setCountryWorking($pays) ;
    }

    /**
     * @return mixed
     */
    public function getTaux()
    {
        return $this->tbs_poste->getHourlyRate();
    }

    /**
     * @param mixed $taux
     */
    public function setTaux($taux)
    {
        $this->tbs_poste->setHourlyRate($taux);
    }
    public function __toString()
    {
        return $this->getUser()->getDisplayName();
    }


}

