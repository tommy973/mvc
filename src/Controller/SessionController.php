<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route("/session", name: "session_info", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response
    {
        // Use AttributeBag to get all the id:s from the session
        $sessionData = new AttributeBag();

        // $currentSession = $request->getSession();

        $data = [
            "currentSession" => $session->all(),
            "sessionLength" => $session->count(),
        ];

        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {

        $session->clear();

        $this->addFlash(
            'notice',
            'Nu är sessionen raderad'
        );

        return $this->redirectToRoute('session_info');
    }
}