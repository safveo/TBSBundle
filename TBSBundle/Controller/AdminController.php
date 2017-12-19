<?php

namespace Time\TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Time\TBSBundle\Entity\TbsManagers;
use Time\TBSBundle\Entity\TbsPole;
use Time\TBSBundle\Entity\TbsPoste;
use Time\TBSBundle\Form\TbsPoleEditType;
use Time\TBSBundle\Form\TbsPoleType;
use Time\TBSBundle\Form\TbsPosteType;
use Time\TBSBundle\Form\TbsUserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class AdminController
 * @package Time\TBSBundle\Controller
 * @Security("has_role('ROLE_TBS_ETUDES_ADMIN')")
 */
class AdminController extends Controller
{
    /**
     * @param Request $request
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     * this fuction return all collaborateurs in TBS_User
     */
    public function collaborateurAction(Request $request, $page)
    {
        /**
         * get Entity manager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * get the number of demandes that will be see on twig  from Tbs_params
         */
        $nbPerPage = $this->container->getParameter('nbcollaborateur');

        /**
         *  get all Tbs_User
         */
        $users = $em->getRepository('TimeTBSBundle:TbsUser')->getTbsUser();

        /**
         * Pagination
         */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users, $request->query->getInt('page', $page)/* page number */
            , $nbPerPage/* limit per page */
        );
        return $this->render('TimeTBSBundle:Admin:index.html.twig', array(
            'users' => $users,
            'paginations' => $pagination));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editUserAction(Request $request, $id)
    {
        /**
         * get Entity manager
         */
        $em = $this->getDoctrine()->getManager();
        /**
         * get user with id passed in parameters
         */
        $tbs_user = $em->getRepository('TimeTBSBundle:TbsUser')->findOneById($id);
        /**
         *  create form edit for tbs_user
         */
        $form = $this->get('form.factory')->create(new TbsUserType(), $tbs_user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /**
             * parse entity tbs_user after submitted form
             */
            $em->persist($tbs_user);
            $em->flush();
            /**
             * add flash message after updated user
             */
            $this->get('session')->getFlashBag()->add('success', "L'utilisateur a été modifié avec succès.");
            /**
             * redirect after submitted
             */
            return new RedirectResponse($this->generateUrl('time_tbs_admin'));

        }
        return $this->render('TimeTBSBundle:Admin:edit.html.twig', array(
            'form' => $form->createView(),
            'user_tbs' => $tbs_user
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function serviceAction(Request $request)
    {
        /**
         * get Entity manager
         */
        $em = $this->getDoctrine()->getManager();
        /**
         * get poles
         */
        $poles = $em->getRepository('TimeTBSBundle:TbsPole')->findAll();
        /**
         * get managers
         */
        $managers = $em->getRepository('TimeTBSBundle:TbsManagers')->findAll();
        /**
         * get postes
         */
        $postes = $em->getRepository('TimeTBSBundle:TbsPoste')->findAll();

        return $this->render('TimeTBSBundle:Admin:service.html.twig', array(
            'postes' => $postes,
            'managers' => $managers,
            'poles' => $poles
        ));
    }

    public function editPoleAction(Request $request, $id)
    {

        /**
         * get Entity manager
         */
        $em = $this->getDoctrine()->getManager();
        /**
         * get user with id passed in parameters
         */
        $tbs_pole = $em->getRepository('TimeTBSBundle:TbsPole')->findOneById($id);
        //var_dump($tbs_pole);die;
        $managers = $em->getRepository('TimeTBSBundle:TbsManagers')->findBy(array('tbs_pole' => $tbs_pole));

        foreach ($managers as $manager) {
            $users[] = $manager->getTbsUser();
        }


        /**
         *  create form edit for tbs_pole
         */


        $form = $this->get('form.factory')->create(new TbsPoleEditType($users), $tbs_pole);
        $form->handleRequest($request);

        /**
         * check if pole has an employees
         */
        $supp = $em->getRepository('TimeTBSBundle:TbsUser')->findOneBy(array('tbs_pole' => $tbs_pole));
        if ($form->isSubmitted()) {
            /**
             * parse entity tbs_user after submitted form
             */
            $managers = $form->getData()->getManager();
            $em->persist($tbs_pole);
            $em->flush();
            $diff = array_diff($managers, $users);
            $suppdif = array_diff($users, $managers);
            foreach ($diff as $user) {
                $tbs_managers = new TbsManagers();
                $tbs_managers->setTbsPole($tbs_pole);
                $tbs_managers->setTbsUser($user);
                $tbs_managers->setActive(1);
                $em->persist($tbs_managers);
                $em->flush();
            }
            foreach ($suppdif as $user) {
                $manager = $em->getRepository('TimeTBSBundle:TbsManagers')->findOneBy(array(
                    'tbs_pole' => $tbs_pole,
                    'tbs_User' => $user
                ));
                $em->remove($manager);
                $em->flush();

            }
            /**
             * add flash message after updated user
             */
            $this->get('session')->getFlashBag()->add('success', "Pole modifié avec succès.");
            /**
             * redirect after submitted
             */
            return new RedirectResponse($this->generateUrl('time_tbs_admin_service'));

        }
        return $this->render('TimeTBSBundle:Admin:editPole.html.twig', array(
            'form' => $form->createView(),
            'pole' => $tbs_pole,
            'supp' => $supp
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * add new pole
     */
    public function newPoleAction(Request $request)
    {
        /**
         * create a new empty entity
         */
        $tbs_pole = new TbsPole();

        /**
         * get Entity manager
         */
        $em = $this->getDoctrine()->getManager();

        $tbs_service = $em->getRepository('TimeTBSBundle:TbsService')->findOneById(1);
        $users = $em->getRepository('TimeTBSBundle:TbsUser')->getTbsUser();
        /**
         *  create form  for tbs_pole
         */
        $form = $this->get('form.factory')->create(new TbsPoleType($users), $tbs_pole);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /**
             * parse entity tbs_user after submitted form
             */
            $managers = $form->getData()->getManager();
            //var_dump($managers);die;
            $tbs_pole->setActive(1);
            $tbs_pole->setTbsService($tbs_service);

            $em->persist($tbs_pole);
            $em->flush();
            foreach ($managers as $user) {
                $tbs_managers = new TbsManagers();
                $tbs_managers->setTbsPole($tbs_pole);
                $tbs_managers->setTbsUser($user);
                $tbs_managers->setActive(1);
                $em->persist($tbs_managers);
                $em->flush();
            }
            /**
             * add flash message after updated user
             */
            $this->get('session')->getFlashBag()->add('success', "Pole ajouté avec succés.");
            /**
             * redirect after submitted
             */
            return new RedirectResponse($this->generateUrl('time_tbs_admin_service'));

        }
        return $this->render('TimeTBSBundle:Admin:addPole.html.twig', array(
            'form' => $form->createView(),
            'pole_tbs' => $tbs_pole
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newPosteAction(Request $request)
    {

        /**
         * create a new empty entity poste
         */
        $tbs_poste = new TbsPoste();

        /**
         * get Entity manager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         *  create form  for tbs_poste
         */
        $form = $this->get('form.factory')->create(new TbsPosteType(), $tbs_poste);
        $tbs_service = $em->getRepository('TimeTBSBundle:TbsService')->findOneById(1);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            /**
             * parse entity tbs_user after submitted form
             */
            $tbs_poste->setActive(1);
            $tbs_poste->setTbsService($tbs_service);
            $tbs_poste->setHourlyRate('60');
            $em->persist($tbs_poste);
            $em->flush();

            /**
             * add flash message after updated user
             */
            $this->get('session')->getFlashBag()->add('success', "Poste ajouté avec succés.");
            /**
             * redirect after submitted
             */
            return new RedirectResponse($this->generateUrl('time_tbs_admin_service'));

        }
        return $this->render('TimeTBSBundle:Admin:addPoste.html.twig', array(
            'form' => $form->createView(),
            'pole_tbs' => $tbs_poste
        ));
    }

    public function deletePoleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * get pole to delete with id
         */
        $pole = $em->getRepository('TimeTBSBundle:TbsPole')->findOneById($id);
        $managers = $em->getRepository('TimeTBSBundle:TbsManagers')->findOneBy(array('tbs_pole' => $pole));
        foreach ($managers as $manager) {
            $em->remove($manager);
        }
        /**
         * remove pole
         */
        $em->remove($pole);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', "Pole supprimé avec succés.");
        return new RedirectResponse($this->generateUrl('time_tbs_admin_service'));

    }

    public function editPosteAction(Request $request, $id)
    {

        /**
         * get Entity manager
         */
        $em = $this->getDoctrine()->getManager();
        /**
         * get user with id passed in parameters
         */
        $tbs_poste = $em->getRepository('TimeTBSBundle:TbsPoste')->findOneById($id);
        /**
         *  create form edit for tbs_pole
         */
        $form = $this->get('form.factory')->create(new TbsPosteType(), $tbs_poste);
        $form->handleRequest($request);
        /**
         * check if pole has an employees
         */
        $supp = $em->getRepository('TimeTBSBundle:TbsUser')->findOneBy(array('tbs_poste' => $tbs_poste));
        if ($form->isSubmitted()) {
            /**
             * parse entity tbs_user after submitted form
             */
            $em->persist($tbs_poste);
            $em->flush();
            /**
             * add flash message after updated user
             */
            $this->get('session')->getFlashBag()->add('success', "Poste modifié avec succès.");
            /**
             * redirect after submitted
             */
            return new RedirectResponse($this->generateUrl('time_tbs_admin_service'));

        }
        return $this->render('TimeTBSBundle:Admin:editPoste.html.twig', array(
            'form' => $form->createView(),
            'poste' => $tbs_poste,
            'supp' => $supp
        ));
    }

    public function deletePosteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /**
         * get pole to delete with id
         */
        $pole = $em->getRepository('TimeTBSBundle:TbsPoste')->findOneById($id);
        /**
         * remove pole
         */
        $em->remove($pole);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', "Poste supprimé avec succés.");
        return new RedirectResponse($this->generateUrl('time_tbs_admin_service'));

    }
}