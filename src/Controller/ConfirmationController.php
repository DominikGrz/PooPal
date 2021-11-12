<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationController extends AbstractController
{
    /**
     * @Route("/confirmation", name="app_confirmation")
     */
    public function index(Request $request): Response
    {
        return $this->render('confirmation/index.html.twig', [
            'amount' => $request->get('amount'),
            'to' => $request->get('to'),
            'controller_name' => 'ConfirmationController'
        ]);
    }
}
