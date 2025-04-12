<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "session")]
    public function sessionPrint(SessionInterface $session): Response
    {
        $session->set("Testing", "Test"); // Ta bort sedan
        // $session->set("gfgfdgfd", "Thgfhgst");
        $session_content = $session;
        $data = [
            "session_info" => $session_content
        ];
        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "session_delete")]
    public function sessionClear(SessionInterface $session): Response
    {
        // Jag vet inte om denna dokumentationen är okej att använda? Jag googlade "symfony sessionInterface"
        // https://github.com/symfony/symfony/blob/6.4/src/Symfony/Component/HttpFoundation/Session/SessionInterface.php
        $session_content = $session->clear();

        $this->addFlash(
            'notice',
            'The data in session has been deleted!'
        );
        
        return $this->redirectToRoute('session');
    }

    #[Route("/card", name: "card")]
    public function cardLandingPage(): Response
    {
        return $this->render('card_landing.html.twig');
    }


}
