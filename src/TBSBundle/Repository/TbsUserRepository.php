<?php

namespace Time\TBSBundle\Repository;

/**
 * Tbs_UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TbsUserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getTbsUser()
    {

        $query = $this->createQueryBuilder('u')
            ->distinct('u.user' )
            ->groupBy('u.user');
        return $query->getQuery()->getResult();

    }
}
