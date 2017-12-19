<?php

namespace Time\TBSBundle\Entity;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\ORM\Mapping as ORM;

/**
 * _Planification_SuiviEtudes
 *
 * @ORM\Table(name="tbs_planification_suivietudes")
 * @ORM\Entity(repositoryClass="Time\TBSBundle\Repository\PlanificationSuiviEtudesRepository")
 */
class PlanificationSuiviEtudes
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
     * @ORM\Column(name="hours_planified", type="string")
     */
    private $hoursPlanified;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hours_worked", type="string")
     */
    private $hoursWorked;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="period", type="date")
     */
    private $period;

    /**
     * @ORM\ManyToOne(targetEntity="\Suivi\EtudesBundle\Entity\DemandeUser", cascade={"persist"} )
     *@ORM\JoinColumn(name="se_demandeuser_id", referencedColumnName="id")
     */
    private $demande_user;
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
     * Set hoursPlanified
     *
     * @param \DateTime $hoursPlanified
     *
     * @return PlanificationSuiviEtudes
     */
    public function setHoursPlanified($hoursPlanified)
    {

        $this->hoursPlanified = $hoursPlanified;
        return $this;
    }

    /**
     * Get hoursPlanified
     *
     * @return \DateTime
     */
    public function getHoursPlanified()
    {

        return $this->hoursPlanified;
    }

    /**
     * Set hoursWorked
     *
     * @param \DateTime $hoursWorked
     *
     * @return PlanificationSuiviEtudes
     */
    public function setHoursWorked($hoursWorked)
    {

        $this->hoursWorked = $hoursWorked;

        return $this;
    }

    /**
     * Get hoursWorked
     *
     * @return \DateTime
     */
    public function getHoursWorked()
    {
        return $this->hoursWorked;
    }

    /**
     * Set period
     *
     * @param \DateTime $period
     *
     * @return _Planification_SuiviEtudes
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
     * @return mixed
     */
    public function getDemandeUser()
    {
        return $this->demande_user;
    }

    /**
     * @param mixed $demande_user
     */
    public function setDemandeUser($demande_user)
    {
        $this->demande_user = $demande_user;
    }

}

