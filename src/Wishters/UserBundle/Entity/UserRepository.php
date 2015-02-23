<?php
/**
 * Created by PhpStorm.
 * User: Kris
 * Date: 22/02/15
 * Time: 11:16
 */

namespace Wishters\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository{

    public function getUserToPropose($user)
    {
        $qb = $this->createQueryBuilder('a');

        $query = $qb->select('a')
                    ->andWhere('a.id != :user')
                    ->setMaxResults(6)
                    ->setParameter('user', $user);

        $result = $query->getQuery()->getResult();

        return $result;
    }
}
