<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class MetricControllerTwig extends AbstractController
{
    #[Route("/metrics", name: "metric")]
    public function metrics(): Response
    {   
        return $this->render('metrics.html.twig');
    }

}
