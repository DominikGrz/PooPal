<?php

namespace App\Controller;

use HttpRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use http\Client\Request;
use http\Client;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index()
    {
        $user = $this->getUser();
        $date = new \DateTime('@'.strtotime('now'));
        $user->setLastlogin($date);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://community-hacker-news-v1.p.rapidapi.com/topstories.json?print=pretty",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: community-hacker-news-v1.p.rapidapi.com",
                "x-rapidapi-key: 256ea649c1msh0768a11f4a53feep10b2afjsn3232879001d0"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $newsdecoded = json_decode($response);

        $stories = [];
        $counter = 0;
        foreach ($newsdecoded as $value) {
            if ($counter == 6) {
                break;
            }
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://community-hacker-news-v1.p.rapidapi.com/item/" . $value . ".json?print=pretty",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: community-hacker-news-v1.p.rapidapi.com",
                    "x-rapidapi-key: 256ea649c1msh0768a11f4a53feep10b2afjsn3232879001d0"
                ],
            ]);

            $response = curl_exec($curl);
            curl_close($curl);
            array_push($stories, json_decode($response));
            $counter++;
        }
        return $this->render('homepage/index.html.twig', [
            'user' => $this->getUser(),
            'controller_name' => 'HomepageController',
            'hacker' => $stories,
        ]);
    }
}