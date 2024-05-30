<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class NewjsontestController extends AbstractController
{
    #[Route("/jsontestpage/start", name: "jsontestpage_start", methods:["GET"])]
    public function jsonTestPageStart(): Response
    {
        return $this->render('test6.html.twig');
    }

    #[Route("/jsontestpage/showjsonwithget", name: "show_json_with_get", methods:["GET"])]
    public function showJsonWithGet(
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

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/jsontestpage/showjsonwithget/{value}", name: "show_json_with_get_value", methods:["GET"])]
    public function showJsonWithGetValue(
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

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/jsontestpage/showjsonwithpost", name: "show_json_with_post", methods:["POST"])]
    public function showJsonWithPost(
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

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/jsontestpage/showjsonwithpost", name: "show_json_with_post_value", methods:["POST"])]
    public function showJsonWithPostValue(
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

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route("/jsontestpage/showjsonwithpostredirect", name: "show_json_with_post_redirect", methods:["POST"])]
    public function showJsonWithPostRedirect(
        Request $request,
        SessionInterface $session
        ): Response
    {
        $tempvalue = $request->get('postButton');

        if (is_null($tempvalue)) {
            $tempvalue = 'button var null';
        }
        $session->set('tempvalue', $tempvalue);

        return $this->redirectToRoute('show_json_from_post_with_redirect');
    }

    #[Route("/jsontestpage/showjsonwithpostredirect", name: "show_json_with_post_value_redirect", methods:["POST"])]
    public function showJsonWithPostValueRedirect(
        Request $request,
        SessionInterface $session
        ): Response
    {
        $postvalue = $request->get('value');
        $tempvalue = $request->get('postButton');
        $session->set('postvalue', $postvalue);
        $session->set('tempvalue', $tempvalue);

        if (is_null($tempvalue)) {
            $tempvalue = 'button var null';
        }

        $session->set('postvalue', $postvalue);
        $session->set('tempvalue', $tempvalue);

        return $this->redirectToRoute('show_json_from_post_with_redirect');
    }

    #[Route("/jsontestpage/showjsonfrompostwithredirect", name: "show_json_from_post_with_redirect")]
    public function showJsonFromPostWithRedirect(
        SessionInterface $session
    ): Response
    {
        $data = [
            'uservalue' => $session->get('postvalue'),
            'button' => $session->get('tempvalue'),
        ];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}