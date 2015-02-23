<?php

namespace Wishters\FrontBundle\Services;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class BlogManager {

    protected $em;
    protected $repository;
    protected $tokenStorage;
    protected $request;
    protected $container;

    public function __construct(Request $request ,EntityManager $em, TokenStorage $tokenStorage, Container $container)
    {
        $this->em = $em;
        $this->request = $request;
        $this->repository = $this->em->getRepository('WishtersFrontBundle:Blog');
        $this->tokenStorage = $tokenStorage;
        $this->container = $container;

        $this->user = $this->tokenStorage->getToken()->getUser();
        if(!is_object($this->user) || !$this->user instanceof UserInterface)
        {
            $this->user = null;
        }
    }

    public function isXmlHttpRequest()
    {
        if ($this->request->isXmlHttpRequest()) {
            return true;
        }

        return false;
    }

    public function getJsonResponse()
    {
        $user = $this->em->getRepository('WishtersUserBundle:User')->find($this->request->get('user'));

        $message = $this->repository->findBy(array('user' => $user),array('date' => 'DESC'));

        $response['message'] = $this->container->get('templating')->render('@WishtersFront/ModalBox/Response/modal_blog_activity.html.twig',
            array('result'=>$message,
                'user'  => $user));

        return new JsonResponse($response);
    }

    private function findUserRelation($user)
    {
        $relations = $this->em->getRepository('WishtersFrontBundle:Relation')->findBy(array('follower' => $user));

        if($relations){
            $data = array();

            foreach($relations as $r){
                $data[] = $r->getFollowed();
            }

            return $data;
        }

        return null;
    }

    public function mergeSpaceBoxActivity()
    {
        $relations = $this->findUserRelation($this->user);
        $annonce = $this->em->getRepository('WishtersFrontBundle:Annonce')->findAnnonceWithRelation($this->user, $relations);
        $message = $this->em->getRepository('WishtersFrontBundle:Blog')->findMessageWithRelation($this->user, $relations);

        $allActivity = array_merge($message, $annonce); // Mix les 2 repertoires d'annonces par date

        usort($allActivity, array($this, 'trie_par_date'));
        return $allActivity;
    }

    private function trie_par_date($a, $b) {
        $date1 = strtotime($a->getDate()->format('r'));
        $date2 = strtotime($b->getDate()->format('r'));
        return $date1 < $date2 ;
    }

}