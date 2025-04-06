<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky", name: "lucky")]
    public function luckyNumbers(): Response
    {
        $number1 = random_int(1, 50);
        $number2 = random_int(1, 50);
        $number3 = random_int(1, 50);
        $number4 = random_int(1, 50);
        $number5 = random_int(1, 50);
        $number6 = random_int(1, 12);
        $number7 = random_int(1, 12);

        $data = [
            'number1' => $number1,
            'number2' => $number2,
            'number3' => $number3,
            'number4' => $number4,
            'number5' => $number5,
            'number6' => $number6,
            'number7' => $number7,
        ];

        return $this->render('lucky.html.twig', $data);
    }
    // #[Route("/home", name: "home")]
    // public function home(): Response
    // {
    //     return $this->render('home.html.twig');
    // }

    // #[Route("/about", name: "about")]
    // public function about(): Response
    // {
    //     return $this->render('about.html.twig');
    // }
}