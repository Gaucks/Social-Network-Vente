<?php

namespace Wishters\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AnnonceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnnonceRepository extends EntityRepository
{
    public function CountUserAnnonce($user)
    {
        return $this->createQueryBuilder('a')
                    ->select('COUNT(a)')
                    ->where('a.user = :user')
                    ->setParameter('user', $user->getId())
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function getAnnonceToPropose($user, $region)
    {
        $qb = $this->createQueryBuilder('a');

        $query = $qb->select('a')
                    ->orderBy('a.date', 'DESC')
                    ->setMaxResults(10);

        if($region != NULL){
            if($region->getSlug() != 'toute-la-france'){ // Non connecté et La région n'est PAS toute la france
                $query->where('a.region = :region')
                    ->setParameter('region', $region);
            }
        }

        if($user){
            $query->andWhere('a.user != :user')
                  ->setParameter('user', $user);
        }

        $result = $query->getQuery()->getResult();

        if(count($result) < 6) // Permet d'ajouter 5 propositions si il n'y en a pas assez au hasard
        {
            return $this->addMorePropose($result, $user);
        }

        return $result;

    }

    protected function addMorePropose($result, $user)
    {

        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->setMaxResults(5);

        if($user){
            $qb->where('a.user != :user')->setParameter('user', $user);
        }
            $resultat= $qb->getQuery()->getResult();

        $merged = array_merge($result, $resultat);

        return $merged;
    } // Permet d'ajouter 5 propositions si il n'y en a pas assez au hasard

    public function searchAnnonce($word)
    {
        $qb = $this->createQueryBuilder('a');

        $query = $qb->select('a')
                    ->where('a.title like :word')
                    ->Orwhere('a.content LIKE :word')
                    ->setParameter('word', '%'.$word.'%')
                    ->addOrderBy('a.date', 'DESC');

        return $query->getQuery()->getResult();
    }

    public function searchAnnonceAjax($word)
    {
        $qb = $this->createQueryBuilder('a');

        $query = $qb->select('a')
            ->where('a.title like :word')
            ->Orwhere('a.content LIKE :word')
            ->setParameter('word', '%'.$word.'%')
            ->addOrderBy('a.date', 'DESC')
            ->setMaxResults(5)
        ;

        return $query->getQuery()->getResult();
    }

    public function findTopHastags()
    {
        $qb = $this->createQueryBuilder('a');

        $query = $qb->select('a.hashtag')->addSelect('COUNT(a)')->groupBy('a.hashtag')->orderBy('a.date', 'ASC');

        return $query->getQuery()->getResult();
    }

    // Trouve les annonces à afficher en prenant en compte les relations de l'utilisateur courant
    public function findAnnonceWithRelation($user, $relations)
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