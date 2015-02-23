<?php

namespace Wishters\FrontBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Wishters\FrontBundle\Entity\Relation;

class RelationController extends Controller{

    public function addAction(Request $request)
    {

        if($request->isXmlHttpRequest()){

            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                return $this->redirect($this->generateUrl('wishters_front_relation_user_not_connected'));
            }

            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('WishtersFrontBundle:Relation');
            $user_repository = $em->getRepository('WishtersUserBundle:User');

            $followed = $user_repository->find($request->attributes->get('id'));

            if($followed) {
                $follow = $repository->findOneBy(array('follower' => $user->getId(), 'followed' => $followed));

                if (!$follow) {
                    $relation = new Relation();

                    $relation->setFollowed($followed)->setFollower($user);
                    $em->persist($relation);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add(
                        'success',
                        'Votre abonnement a été pris en compte!'
                    );

                    // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
                    $response = new JsonResponse();
                    // Ici, nous définissons le Content-type pour dire que l'on renvoie du JSON et non du HTML
                    $response->headers->set('Content-Type', 'application/json');

                    return $response;
                }

                return false;
            }
        }

    }

    public function removeAction(Request $request){

        if($request->isXmlHttpRequest()) {

            $user = $this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                return $this->redirect($this->generateUrl('wishters_front_relation_user_not_connected'));
            }

            $em = $this->getDoctrine()->getManager();

            $repository = $em->getRepository('WishtersFrontBundle:Relation');
            $user_repository = $em->getRepository('WishtersUserBundle:User');

            $followed = $user_repository->find($request->attributes->get('id'));

            if ($followed) {
                $relationCheck = $repository->findRelation($user, $followed);

                if ($relationCheck) {
                    $em->remove($relationCheck);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add(
                        'success',
                        'Votre désabonnement a été pris en compte!'
                    );

                    // Créons nous-mêmes la réponse en JSON, grâce à la fonction json_encode()
                    $response = new JsonResponse();
                    // Ici, nous définissons le Content-type pour dire que l'on renvoie du JSON et non du HTML
                    $response->headers->set('Content-Type', 'application/json');

                    return $response;

                } else {
                    throw $this->createNotFoundException('Unable to find Ingredient entity.');
                }
            }
            else{
                throw $this->createNotFoundException('Unable to find Ingredient entity.');
            }
        }

        return new Response('Cette requete ne peut pas être exécutée directement...');

    }

    public function notConnectedAction()
    {
        return $this->render('WishtersFrontBundle:Relation:notconnected.html.twig');
    }

}