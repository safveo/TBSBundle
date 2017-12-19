<?php


namespace Time\TBSBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Time\TBSBundle\Services\DependencyManager;

class WSDataManager extends DependencyManager
{
    /**
     * @param $date_selected
     * @param $user
     * @return int
     * this function is the php version of the stored procedure in mysql
     */
    public function getHoursforUser($date_selected, $user)
    {

        $total_hours = 0;
        $boolean_lastday = 0;
        $date_entred = $date_selected->format('Y-m-01');
        $last_day = clone ($date_selected);
        $last_day->modify('last day of this month');
        while ($boolean_lastday != 1) {
            $em = $this->getManager();
            $query = $em->createQueryBuilder('')
                ->select('1')
                ->from('TimeTBSBundle:AdmPublicholiday', 'ad')
                ->innerJoin('UserUserBundle:User', 'u')
                ->where('ad.admContryId = u.country_working')
                ->andWhere('ad.date = :date_selected')
                ->andWhere('u.id = :user_id')
                ->setParameters(array('date_selected' => $date_entred, 'user_id' => $user))
                ->getQuery();
            $result = $query->getResult();
            if (!$result) {

                if (intval((date('w', strtotime($date_entred)) > 0)) and (intval(date('w', strtotime($date_entred)) < 5))) {
                    $total_hours = $total_hours + 8;

                } elseif (intval(date('w', strtotime($date_entred)) == 5)) {
                    $total_hours = $total_hours + 7;

                }

            }
            $d = new \DateTime($date_entred);
            $day = clone ($d);

            if ($day->format('d') == $last_day->format('d')) {

                $boolean_lastday = 1;
            } else {

                $d->modify('+1 day');
                $date_entred = $d->format('Y-m-d');

            }
        }


        return $total_hours;
    }

    public function getPlanification($user)
    {
        $em = $this->getManager();
        $start = new \DateTime('first day of this month');
        $date = new \DateTime(date_format($start, 'Y-m-d'));
        $end = date_modify($date, '+1 month');
        $start->modify('-1 day');
        $planification = $em->getRepository('TimeTBSBundle:PlanificationSuiviEtudes')->getDemandeUser($user, $start, $end);
        return $planification;

    }

    public function getfilerPlanification($date, $user)
    {
        $em = $this->getManager();
        $start = new \DateTime(date_format($date, 'Y-m-d'));
        $start->modify('first day of this month');
        $final = clone $start;
        $end = date_modify($final, '+1 month');
        $start->modify('-1 day');
        $planification = $em->getRepository('TimeTBSBundle:PlanificationSuiviEtudes')->getDemandeUser($user, $start, $end);
        return $planification;

    }


}
