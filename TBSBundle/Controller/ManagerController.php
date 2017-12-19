<?php

namespace Time\TBSBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Time\TBSBundle\Entity\PlanificationSuiviEtudes;

/**
 * Class ManagerController
 * @package Time\TBSBundle\Controller
 * @Security("has_role('ROLE_TBS_ETUDES_MANAGER')")
 */
class ManagerController extends Controller
{
    public function indexAction(Request $request, $page)
    {

        $date = new \DateTime();
        $date_last_month = clone $date;
        $date_last_month->modify('-1 month');
        $em = $this->getDoctrine()->getManager();
        /**
         * get all user from tbs_user table
         */
        $usrs = $em->getRepository('TimeTBSBundle:TbsUser')->getTbsUser();
        $poles = $em->getRepository('TimeTBSBundle:TBSPole')->findAll();
        /**
         * get ws.data.service
         */
        $datamanager = $this->get('ws.data.manager');
        /**
         * demandes planified orderBy demande
         */
        foreach ($usrs as $usr) {
            $output = new \stdClass();
            $output->planifications = $datamanager->getPlanification($usr->getUser());
            $output->planificationsLastMonth = $datamanager->getfilerPlanification($date_last_month, $usr->getUser());
            $output->user = $usr;
            $output->hours = $datamanager->getHoursforUser($date, $usr->getUser());
            $output->hours_capacity = round($datamanager->getHoursforUser($date, $usr->getUser()) * $usr->getCapacityPercent() / 100);
            $planifications_manager[] = $output;
        }
        /**
         * get number of rows in table
         */
        $nbPerPage = $this->container->getParameter('nbdemande');
        /**
         * knp_paginator generate pagination from users and nuber of rows in one table
         */
        $paginator = $this->get('knp_paginator');
        $users = $paginator->paginate(
            $usrs, $request->query->getInt('page', $page)/* page number */
            , $nbPerPage/* limit per page */
        );

        return $this->render('TimeTBSBundle:Manager:index.html.twig', array(
            'date' => $date,
            'users' => $users,
            'poles' => $poles,
            'planifications_manager' => $planifications_manager

        ));

    }


    public function filterAction(Request $request, $page, $date)
    {
        $date = new \DateTime($date);
        $aff_date = clone $date;
        $date_last_month = clone $date;
        $date_last_month->modify('-1 month');
        $em = $this->getDoctrine()->getManager();
        /**
         * get all user from tbs_user table
         */
        $usrs = $em->getRepository('TimeTBSBundle:TbsUser')->getTbsUser();
        $poles = $em->getRepository('TimeTBSBundle:TBSPole')->findAll();
        /**
         * get ws.data.service
         */
        $datamanager = $this->get('ws.data.manager');
        /**
         * demandes planified orderBy demande
         */
        foreach ($usrs as $usr) {
            $output = new \stdClass();
            $output->planifications = $datamanager->getfilerPlanification($date, $usr->getUser());
            $output->planificationsLastMonth = $datamanager->getfilerPlanification($date_last_month, $usr->getUser());
            $output->user = $usr;
            $output->hours = $datamanager->getHoursforUser($date, $usr->getUser());
            $output->hours_capacity = round($datamanager->getHoursforUser($date, $usr->getUser()) * $usr->getCapacityPercent() / 100);
            $planifications_manager[] = $output;


        }

        /**
         * get number of rows in table
         */
        $nbPerPage = $this->container->getParameter('nbdemande');
        /**
         * knp_paginator generate pagination from users and nuber of rows in one table
         */
        $paginator = $this->get('knp_paginator');
        $users = $paginator->paginate(
            $usrs, $request->query->getInt('page', $page)/* page number */
            , $nbPerPage/* limit per page */
        );

        return $this->render('TimeTBSBundle:Manager:index.html.twig', array(
            'date' => $aff_date,
            'users' => $users,
            'poles' => $poles,
            'planifications_manager' => $planifications_manager

        ));

    }

    /**
     * @param Request $request
     * edit hoursPlanified for manager
     */
    public function EditHoursPlanifiedAction(Request $request)
    {
        /**
         * get new value from bootstrap editable
         */
        $newValue = $request->get('editvalue');
        /**
         * convert to time
         */

        $date_first = new \DateTime('1970-01-01');
        $hours = intval($newValue);
        $d = $date_first->format($hours . ':i' . ':s');

        //var_dump($xd);die;
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
        $planification = $em->getRepository('TimeTBSBundle:PlanificationSuiviEtudes')->findOneById($iddemandeUser);
        $planification->setHoursPlanified($d);

        $em->persist($planification);
        $em->flush();

        die;

    }

}