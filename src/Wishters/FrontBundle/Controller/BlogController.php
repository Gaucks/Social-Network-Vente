<?php

namespace Wishters\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Wishters\FrontBundle\Services\BlogManager;

class BlogController extends Controller
{
    public function indexAction()
    {
        $blogHandler = $this->get('blog_handler');

        if($blogHandler->process()) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Vos changements ont été sauvegardés!'
            );
            return $this->redirect($this->generateUrl('wishter_front_user_spacebox'));
        }

        return $this->render('modal_add_blog.html.twig', array('form' => $blogHandler->createView()));
    }

    public function addAction(Request $request)
    {
        if($request->isXmlHttpRequest()){

            $blog_handler = $this->get('blog_handler');

            $response['message'] = $this->render('@WishtersFront/ModalBox/Response/modal_add_blog.html.twig', array('form'=>$blog_handler->createView()))->getContent();

            return new JsonResponse($response);
        }
    }

    public function addTraitementAction()
    {
        $blogHandler = $this->get('blog_handler');

        if($blogHandler->process()) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Vos changements ont été sauvegardés!'
            );
            return $this->redirect($this->generateUrl('wishter_front_user_spacebox'));
        }

        return $this->redirect($this->generateUrl('wishter_front_user_spacebox'));
    }

    public function resumeAction()
    {
        $blogManager = $this->get('blog_manager');

        if($blogManager->isXmlHttpRequest()){
            return $blogManager->getJsonResponse();
        }


        return $this->redirect($this->generateUrl('wishter_front_user_spacebox'));
    }
}
