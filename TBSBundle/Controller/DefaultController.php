<?php

namespace Time\TBSBundle\Controller;

use DateTime;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Time\TBSBundle\Entity\PlanificationSuiviEtudes;
use Time\TBSBundle\Repository\PlanificationSuiviEtudesRepository;
use Symfony\Component\HttpFoundation\Request;
use Time\TBSBundle\Services\WSDataManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class DefaultController
 * @package Time\TBSBundle\Controller
 * @Security("has_role('ROLE_TBS_ETUDES_USER')")
 */
class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     * this Action returned the planified demandes for every connected User
     */
    public function indexAction(Request $request, $page)
    {
        /**
         * get Entity Manager
         */
        $em = $this->getDoctrine()->getManager();
        /**
         * Intialisation of the first date
         */
        $date_first = new \DateTime('1970-01-01');
        /**
         * get connected User
         */
        $user = $this->get('security.context')->getToken()->getUser();
        /**
         * get User from TbsUser
         */
        $usr = $em->getRepository('TimeTBSBundle:TbsUser')->findOneByUser($user);
        /**
         * get capacity_percent of usr
         */
        $percent = $usr->getCapacityPercent();
        /**
         * get current date
         */
        $date = new \DateTime();

        /**
         * get ws.data.service
         */
        $datamanager = $this->get('ws.data.manager');

        /**
         * get the number of demandes that will be see on twig  from Tbs_params
         */
        $nbPerPage = $this->container->getParameter('nbdemande');
        /**
         * demandes planified orderBy demande and get User hours worked by month
         */
        $result = ($datamanager->getHoursforUser($date, $user) * $percent) / 100;

        $planifications = $datamanager->getPlanification($user);

        /**
         * calculate hours realisé in all demandes
         */

        $hours_worked = 0;
        foreach ($planifications as $planification) {
            $hour_worked_demande = strtotime($planification->getHoursWorked());
            $d= date('H', $hour_worked_demande);
            $date_modif= clone $date_first;
            $hours= intval($d);
            $date_modif->modify('+'.$hours.'hours');
            $diff = $date_first->diff($date_modif);
            $hours = $diff->h;
            $hours = $hours + ($diff->days * 24);
            $hours_worked = $hours + $hours_worked;
        }

        /**
         * calculate hours a saisir
         */
        $result = $result - $hours_worked;
        /**
         * Pagination
         */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $planifications, $request->query->getInt('page', $page)/* page number */
            , $nbPerPage/* limit per page */
        );
        return $this->render('TimeTBSBundle:Default:index.html.twig', array(
            'planifications' => $pagination,
            'date' => $date,
            'hours' => round($result)
        ));
    }

    /**
     * @param Request $request
     * @param $page
     * @param $date
     * @return \Symfony\Component\HttpFoundation\Response
     *  Saisir temps with data filter
     */
    public function filterAction(Request $request, $page, $date)
    {
        /**
         * get Entity Manager
         */
        $em = $this->getDoctrine()->getManager();
        $date_first = new \DateTime('1970-01-01');
        /**
         * get connected User
         */
        $user = $this->get('security.context')->getToken()->getUser();
        $date = new \DateTime($date);
        $aff_date = clone $date;
        /**
         * get ws.data.service
         */
        $datamanager = $this->get('ws.data.manager');
        /**
         * get User from TbsUser
         */
        $usr = $em->getRepository('TimeTBSBundle:TbsUser')->findOneByUser($user);

        /**
         * get capacity_percent of usr
         */
        $percent = $usr->getCapacityPercent();


        /**
         * get the number of demandes that will be see on twig  from Tbs_params
         */
        $nbPerPage = $this->container->getParameter('nbdemande');

        /**
         * demandes planified orderBy demande and get User hours worked by month
         */
        $result = ($datamanager->getHoursforUser($date, $user) * $percent) / 100;
        $planifications = $datamanager->getfilerPlanification($date, $user);

        /**
         * calculate hours realisé in all demandes
         */

        $hours_worked = 0;
        foreach ($planifications as $planification) {
            $hour_worked_demande = strtotime($planification->getHoursWorked());
            $d= date('H', $hour_worked_demande);
            $date_modif= clone $date_first;
            $hours= intval($d);
            $date_modif->modify('+'.$hours.'hours');
            $diff = $date_first->diff($date_modif);
            $hours = $diff->h;
            $hours = $hours + ($diff->days * 24);
            $hours_worked = $hours + $hours_worked;
        }

        /**
         * calculate hours a saisir
         */
        $result = $result - $hours_worked;
        /**
         * Pagination
         */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $planifications, $request->query->getInt('page', $page)/* page number */
            , $nbPerPage/* limit per page */
        );

        return $this->render('TimeTBSBundle:Default:index.html.twig', array(
            'planifications' => $pagination,
            'date' => $aff_date,
            'hours' => round($result)
        ));
    }

    /**
     * @param Request $request
     * @return mixed
     *  update hoursWorked for user
     */
    public function EditHoursWorkedAction(Request $request)
    {
        /**
         * get new value from bootstrap editable
         */
        $newValue = $request->get('editvalue');
        /**
         * convert to time
         */
        $date_first = new \DateTime('1970-01-01');
        $hours= intval($newValue);
       $d=$date_first->format($hours.':i'.':s');
//var_dump($d);die;
        /**
         * get id demande that will be updated
         */
        $iddemandeUser = $request->get('idDemande');
        /**
         * get Entity Manager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * get planification
         */
        $planification = $em->getRepository('TimeTBSBundle:PlanificationSuiviEtudes')->findOneBy(array(
            'demande_user'=>$iddemandeUser));
       $planification->setHoursWorked($d);

        $em->persist($planification);
        $em->flush();

        die;

    }

}
