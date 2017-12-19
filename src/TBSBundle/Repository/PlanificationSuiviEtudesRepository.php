<?php

namespace Time\TBSBundle\Repository;
use Suivi\EtudesBundle\Entity\DemandeUser;

/**
 * Tbs_Planification_SuiviEtudesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PlanificationSuiviEtudesRepository extends \Doctrine\ORM\EntityRepository
{

    public function getDemandeUser($user,$start,$end)
    {

        $query = $this->createQueryBuilder('pl')
            ->where('pl.period >:start and pl.period <:end' )
            ->leftJoin('pl.demande_user','du')
            ->andWhere('du.user = :user')
            ->leftJoin('du.demande','d')
            ->groupBy('d.id')
            ->orderBy('du.id')
            ->setParameters(array('end'=>$end,
                'start'=>$start,
                'user'=>$user));
      return $query->getQuery()->getResult();

    }
    public function getDemandeAdmin($start,$end)
    {

        $query = $this->createQueryBuilder('pl')
            ->where('pl.period >=:start and pl.period <:end' )
            ->leftJoin('pl.demande_user','du')
            ->leftJoin('du.demande','d')
            ->groupBy('d.id')
            ->orderBy('du.id')
            ->setParameters(array('end'=>$end,
                'start'=>$start,
            ));
        return $query->getQuery()->getResult();
    }
}