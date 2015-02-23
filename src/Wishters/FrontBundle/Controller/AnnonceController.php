<?php

namespace Wishters\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Wishters\FrontBundle\Entity\Annonce;
use Wishters\FrontBundle\Entity\Search;
use Wishters\FrontBundle\Form\Type\SearchType;

/**
 * Class AnnonceController
 * @package Wishters\FrontBundle\Controller
 */
class AnnonceController extends Controller
{
    /**
     * @param Annonce $annonce
     * @return Response
     */
    public function showAction(Annonce $annonce)
    {
        $annonceManager  = $this->get('annonce_manager');

        $region       = $annonceManager->finRegionByAnnonce($annonce);
        $countAnnonce = $annonceManager->countUserAnnonce($annonce->getUser());
        $propose      = $annonceManager->findAnnonceToPropose($region);

        return $this->render('WishtersFrontBundle:Annonce:show.html.twig', array('region' => $region,
            'annonce' => $annonce,
            'countAnnonce' => $countAnnonce,
            'propose'   => $propose,
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function showByHashtagAction(Request $request)
    {
        $annonceManager  = $this->get('annonce_manager');

        $hashtag  = $request->get('hashtag');
        $annonce  = $annonceManager->findAnnonceByHashtag($hashtag);
        $propose  = $annonceManager->findAnnonceToPropose($annonce[0]->getRegion()); // Algoritme à modififer pour trouver " toute la france " au lieu de [0]

        return $this->render('WishtersFrontBundle:Annonce/Hashtag:show.html.twig', array('annonces' => $annonce, 'hashtag' => $hashtag,'propose'   => $propose,));
    }

    /**
     * @return Response
     */
    public function showAllHashtagAction()
    {
        $annonceManager  = $this->get('annonce_manager');

        $propose  = $annonceManager->findAnnonceToPropose(null);
        $hashtags = $annonceManager->findTopHastags();


        return $this->render('@WishtersFront/Annonce/Hashtag/show_all_hashtag.html.twig', array('hashtags' => $hashtags, 'propose' => $propose,'hashtag' => 'Hashtags les plus populaires'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addAction(Request $request)
    {
        if($request->isXmlHttpRequest()){

            $annonce_handler = $this->get('annonce_handler');

            $response['message'] = $this->render('@WishtersFront/ModalBox/Response/modal_add_annonce.html.twig', array('form'=>$annonce_handler->createView()))->getContent();

            return new JsonResponse($response);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addTraitementAction(Request $request)
    {
        $annonce_handler = $this->get('annonce_handler');

        if($annonce_handler->onProcess()){
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre annonce vient d\'etre publiée!'
            );
            return $this->redirect($this->generateUrl('wishters_front_homepage'));
        }

        $session = $this->get('session');
        $session->set('formulaire', $request->get('annonce'));

        return $this->redirect($this->generateUrl('wishters_front_annonce_add_default'));

    }

    /**
     * @return Response
     */
    public function addDefaultAction()
    {

        $annonceManager  = $this->get('annonce_manager');
        $annonceHandler  = $this->get('annonce_handler');

        $propose  = $annonceManager->findAnnonceToPropose($this->getUser()->getRegion());
        $countAnnonce = $annonceManager->countUserAnnonce($this->getUser());

        // Controle si le formulaire est envoyé de la modalBox
        if($annonceHandler->onModalSend()){

            if(!$annonceHandler->onProcess()){

                $annonceHandler->removeSession(); // Supprime la session

                return $this->render('@WishtersFront/Annonce/Add/add_annonce.html.twig', array(
                    'form' => $annonceHandler->createView(),
                    'region' => null,
                    'countAnnonce' => $countAnnonce,
                    'propose' => $propose ));

            }
        }

        if($annonceHandler->onProcess()){
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre annonce vient d\'etre publiée!'
            );
            return $this->redirect($this->generateUrl('wishters_front_homepage'));
        }

        return $this->render('@WishtersFront/Annonce/Add/add_annonce.html.twig', array(
            'form' => $annonceHandler->createView(),
            'region' => null,
            'countAnnonce' => $countAnnonce,
            'propose' => $propose ));
    }

    /**
     * @param Annonce $annonce
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editAction(Annonce $annonce)
    {
        $annonceManager  = $this->get('annonce_manager');
        $annonceHandler  = $this->get('annonce_handler');

        $propose  = $annonceManager->findAnnonceToPropose($annonce->getRegion());
        $countAnnonce = $annonceManager->countUserAnnonce($annonce->getUser());
        if($annonce->getPicture()){
            $annoncePicture = 'uploads/annonce/'.$annonce->getPicture()->getPath();
        }
        else{
            $annoncePicture = null;
        }
        if($annonceHandler->onProcess()){
            $this->get('session')->getFlashBag()->add(
                'success',
                'Vos changements ont été sauvegardés!'
            );
            return $this->redirect($this->generateUrl('wishters_front_annonce_show', array('id' => $annonce->getId())));
        }

        return $this->render('WishtersFrontBundle:Annonce/Edit:edit.html.twig', array(
            'form' => $annonceHandler->createView($annonce),
            'region' => null,
            'countAnnonce' => $countAnnonce,
            'annonce' => $annonce,
            'propose' => $propose,
            'annonce_picture' => $annoncePicture));
    }

    /**
     * @param Annonce $annonce
     * @return Response
     */
    public function removeAction(Annonce $annonce)
    {
        $annonceManager  = $this->get('annonce_manager');

        $propose      = $annonceManager->findAnnonceToPropose($annonce->getRegion());
        $countAnnonce = $annonceManager->countUserAnnonce($annonce->getUser());

        return $this->render('WishtersFrontBundle:Annonce/Remove:remove.html.twig',array('annonce' => $annonce,
            'region' => null,
            'countAnnonce' => $countAnnonce,
            'annonce' => $annonce,
            'propose' => $propose ));
    }

    /**
     * @param Annonce $annonce
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeTraitementAction(Annonce $annonce)
    {
        $annonceManager = $this->get('annonce_manager');

        if($annonceManager->removeAnnonce($annonce)){
            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre annonce a bien été supprimée!'
            );
            return $this->redirect($this->generateUrl('wishter_front_user_spacebox'));
        }
        return $this->redirect($this->generateUrl('wishters_front_welcome'));
    }

    /**
     * @return Response
     */
    public function searchAction()
    {
        $form = $this->createForm(new SearchType(), new Search());

        return $this->render('WishtersFrontBundle:Template/Search:search_header.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function searchTraitementAction(Request $request)
    {
        $annonceManager  = $this->get('annonce_manager');

        $form = $this->createForm(new SearchType(), new Search());

        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isValid()) {
            $result = $this->getDoctrine()->getRepository('WishtersFrontBundle:Annonce')->searchAnnonce($form->getData()->getContent());

            $propose  = $annonceManager->findAnnonceToPropose(null);

            return $this->render('WishtersFrontBundle:Recherche:show.html.twig', array(
                'recherche' => $form->getData()->getContent(),
                'propose'   => $propose,
                'annonces' => $result));
        }
        else{
            return 'Renvoyer un formulaire nouveau de recherche';
        }

    }

    public function ajaxSearchAction(Request $request, $search)
    {
        if($request->isXmlHttpRequest()) {

            $result = $this->getDoctrine()->getRepository('WishtersFrontBundle:Annonce')
                ->searchAnnonceAjax($search);

            $actus = array();

            foreach($result as $actu){
                $actus[] = array(
                    'author'    => $actu->getUser()->getUsername(),
                    'price'     => $actu->getPrice(),
                    'title'     => $actu->getTitle(),
                    'id'        => $actu->getId());
            }

            $response = new JsonResponse();

            return $response->setData(array('actu' => $actus));
        }

        return 'lol je crois pas';
    }

}
