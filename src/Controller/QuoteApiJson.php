<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteApiJson
{
    #[Route("/api/quote", name: "quote")]
    public function jsonQuote(): Response
    {
        $randomNumber = random_int(0, 4);
        // https://www.php.net/manual/en/function.date.php

        // Problem med att json kommer tillbaka med konstiga tecken:
        // https://stackoverflow.com/questions/17866662/json-encode-php-showing-strange-characters#:~:
        // text=json_encode(%27yourarabiccharacters%27%2C%20JSON_UNESCAPED_UNICODE)%3B


        $quotes = [
            'Code is like humor. When you have to explain it, it’s bad.',
            'The best way to predict the future is to invent it.',
            'Don’t comment bad code — rewrite it.',
            'Every great developer you know got there by solving problems they were unqualified to solve — until they actually did it.',
            'Var inte rädd för att börja om. Du börjar inte från noll, du börjar från erfarenhet.'
        ];
        // https://www.php.net/manual/en/function.date-default-timezone-set.php
        // https://www.php.net/manual/en/timezones.europe.php
        date_default_timezone_set("Europe/Stockholm");

        $randomQuote = $quotes[$randomNumber];
        $todaysDate = date("Y-m-d");
        $timeStamp = date("Y-m-d H:i:s");

        $data = [
            'quote' => $randomQuote,
            'todaysDate' => $todaysDate,
            'timeStamp' => $timeStamp
        ];


        // $response = new Response();
        // Behöver en commit till
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        // $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
        // $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
