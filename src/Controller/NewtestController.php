<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class NewtestController extends AbstractController
{
    #[Route("/testpage/start", name: "testpage_start", methods:["GET"])]
    public function testPageStart(): Response
    {
        return $this->render('test5.html.twig');
    }

    #[Route("/testpage/showtwigwithget", name: "show_twig_with_get", methods:["GET"])]
    public function showTwigWithGet(
        Request $request,
    ): Response
    {
        $tempvalue = $request->get('getButton');

        if (is_null($tempvalue)) {
            $tempvalue = 'button var null';
        }
        $data = [
            'button' => $tempvalue,
        ];

        return $this->render('showtwig.html.twig', $data);
    }

    #[Route("/testpage/showtwigwithget/{value}", name: "show_twig_with_get_value", methods:["GET"])]
    public function showTwigWithGetValue(
        Request $request,
        int $value = 1,
    ): Response
    {
        $tempvalue = $request->get('getButton');

        if (is_null($tempvalue)) {
            $tempvalue = 'button var null';
        }
        $data = [
            'uservalue' => $value,
            'button' => $tempvalue,
        ];

        return $this->render('showtwig.html.twig', $data);
    }

    #[Route("/testpage/showtwigwithpost", name: "show_twig_with_post", methods:["POST"])]
    public function showTwigWithPost(
        Request $request,
        ): Response
    {
        $tempvalue = $request->get('postButton');

        if (is_null($tempvalue)) {
            $tempvalue = 'button var null';
        }
        $data = [
            'button' => $tempvalue,
        ];

        return $this->render('showtwig.html.twig', $data);
    }

    #[Route("/testpage/showtwigwithpost", name: "show_twig_with_post_value", methods:["POST"])]
    public function showTwigWithPostValue(
        Request $request,
        ): Response
    {
        $postvalue = $request->get('postValue');
        $tempvalue = $request->get('postButton');

        if (is_null($tempvalue)) {
            $tempvalue = 'button var null';
        }
        $data = [
            'uservalue' => $postvalue,
            'button' => $tempvalue,
        ];

        return $this->render('showtwig.html.twig', $data);
    }

    #[Route("/testpage/showtwigwithpostredirect", name: "show_twig_with_post_redirect", methods:["POST"])]
    public function showTwigWithPostRedirect(
        Request $request,
        SessionInterface $session
        ): Response
    {
        $tempvalue = $request->get('postButton');

        if (is_null($tempvalue)) {
            $tempvalue = 'button var null';
        }
        $session->set('tempvalue', $tempvalue);

        return $this->redirectToRoute('show_twig_from_post_with_redirect');
    }

    #[Route("/testpage/showtwigwithpostredirect", name: "show_twig_with_post_value_redirect", methods:["POST"])]
    public function showTwigWithPostValueRedirect(
        Request $request,
        SessionInterface $session
        ): Response
    {
        $postvalue = $request->get('postValue');
        $tempvalue = $request->get('postButton');
        $session->set('postvalue', $postvalue);
        $session->set('tempvalue', $tempvalue);

        if (is_null($tempvalue)) {
            $tempvalue = 'button var null';
        }

        $session->set('postvalue', $postvalue);
        $session->set('tempvalue', $tempvalue);

        return $this->redirectToRoute('show_twig_from_post_with_redirect');
    }

    #[Route("/testpage/showtwigfrompostwithredirect", name: "show_twig_from_post_with_redirect")]
    public function showTwigFromPostWithRedirect(
        SessionInterface $session
    ): Response
    {
        $data = [
            'uservalue' => $session->get('postvalue'),
            'button' => $session->get('tempvalue'),
        ];

        return $this->render('showtwig.html.twig', $data);
    }

}