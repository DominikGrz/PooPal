<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiTestsController extends AbstractController
{
    /**
     * @Route("/apitests", name="app_api_tests")
     */
    public function index(Request $request): Response
    {
        $name = NULL;
        $from = NULL;
        $chance = NULL;
        $api_json = NULL;
        if(!empty($request->get('apicall'))) {
            $apicall1 = $request->get('apicall');
            $api_url = 'https://api.nationalize.io/?name=' . urlencode($apicall1); # urlencode für leerzeichen etc
            $api_json = file_get_contents($api_url);
            $decoded = json_decode($api_json, true);
            dump($decoded);
            $name = "Not found";
            $from = "Not found";
            $chance = "Not found";
            if(!empty($decoded['country'][0])) {
                $name = $decoded['name'];
                $from = $decoded['country'][0]['country_id'];
                $chance = $decoded['country'][0]['probability'];
            }
        }
        $dog = 'https://dog.ceo/api/breeds/image/random';
        $dog_json = file_get_contents($dog);
        $dog_decoded = json_decode($dog_json, true);
        $picurl = $dog_decoded['message'];

        $ip_url = 'https://api.ipify.org?format=json';
        $ip_decoded = json_decode(file_get_contents($ip_url), true);
        $ip = $ip_decoded['ip'];

        $bitcoin_url = 'https://api.coindesk.com/v1/bpi/currentprice.json';
        $bitcoin_decoded = json_decode(file_get_contents($bitcoin_url), true);
        $bitcoin_raw = str_replace(',','',$bitcoin_decoded['bpi']['EUR']['rate']);
        $bitcoin = round($bitcoin_raw,2);

        #AIzaSyALTQH0Ivv606k2l2_LCTw0625u3xL5Yqg google maps api-key

        return $this->render('api_tests/index.html.twig', [
            'controller_name' => 'ApiTestsController',
            'name' => $name,
            'from' => $from,
            'chance' => $chance,
            'dog' => $picurl,
            'ip' => $ip,
            'bitcoin' => $bitcoin,
        ]);
    }
}
