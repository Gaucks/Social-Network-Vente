<?php

namespace Wishters\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlogRepository extends EntityRepository
{
    // Trouve les annonces à afficher en prenant en compte les relations de l'utilisateur courant
    public function findMessageWithRelation($user, $relations)
    {
        $query = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.user = :id')
            ->orWhere('a.user IN (:relations)')
            ->setParameters(array('id' => $user->getId(), 'relations' => $relations))
            ->getQuery()
            ->getResult();

        return $query;
    }
}
