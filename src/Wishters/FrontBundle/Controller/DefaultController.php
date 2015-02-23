<?php

namespace Wishters\FrontBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package Wishters\FrontBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function welcomeAction()
    {
        $this->get('session')->set('welcome_page_visited', true);
        //$this->get('session')->remove('welcome_page_visited'); Pour détruire la session
        return $this->render('WishtersFrontBundle:Default:welcome.html.twig');
    }

    /**
     * L'utilisateur est connecté : on le redirige sur son SpaceBox
     *
     * Sinon
     *
     * L'utilisateur est rediriger sur la page d'accueil " Welcome "
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if(!is_object($user) || !$user instanceof UserInterface){
            if($this->get('session')->has('welcome_page_visited')){
                return $this->redirect($this->generateUrl('wishter_front_region_show'));
            }

            return $this->redirect($this->generateUrl('wishters_front_welcome'));
        }

        return $this->redirect($this->generateUrl('wishter_front_user_spacebox'));
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findMyRegionAction()
    {
        return $this->render('WishtersFrontBundle:Default:findMyRegion.html.twig');
    }

}
