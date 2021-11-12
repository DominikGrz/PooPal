<?php

namespace App\Controller;

use Cassandra\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileEditController extends AbstractController
{
    /**
     * @Route("/profile/edit", name="app_profile_edit")
     *
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
            if(!empty($request->get('username')||!empty($request->get('telnumber')))){
                if(!empty($request->get('username'))){
                    $user->setUsername($request->get('username'));
                }
                if(!empty($request->get('telnumber'))){
                    $user->setTelnumber($request->get('telnumber'));
                }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('profile_edit/index.html.twig', [
            'user' => $this->getUser(),
            'controller_name' => 'ProfileEditController',
        ]);
    }
}
