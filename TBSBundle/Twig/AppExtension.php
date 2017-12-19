<?php
/**
 * Created by PhpStorm.
 * User: abdelwahed_sl
 * Date: 03/11/2017
 * Time: 10:49
 */

namespace Time\TBSBundle\Twig;


use DateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends \Twig_Extension

{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    private $container, $translator, $route;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->translator = $this->container->get('translator');
    }

    public function getFunctions()
    {
        return array(

            'getNumberOfHours' => new \Twig_Function_Method($this, 'getNumberOfHours'),
            'monthbeforeandafter' => new \Twig_Function_Method($this, 'monthbeforeandafter'),


        );
    }


    public function getNumberOfHours($duree)
    {
        $hours = explode(':', $duree);
        return round(intval($hours[0]));
    }

    public function monthbeforeandafter($date)
    {
        $datenow = new DateTime('now');
        $datenow->modify('first day of this month');
        $date->modify('first day of this month');
        $monthafter = clone $datenow;
        $monthbefore = clone $datenow;
        $monthafter->modify('+2 month');
        $monthbefore->modify('-2 month');
        if ($date < $monthafter and $date > $monthbefore) {
            return true;

        } else {
            return false;
        }
    }


    public function getName()
    {
        return 'parameters';
    }
}