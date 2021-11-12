<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SendMoneyController extends AbstractController
{
    /**
     * @Route("/sendmoney", name="app_sendmoney")
     */
    public function index(Request $request): Response
    {
        if(!empty($request->get('recipient'))) {
            $repository = $this->getDoctrine()->getRepository(User::class);
            $currentuser = $this->getUser();
            $amount = $request->get('amount')*100;
            $targetname = $request->get('recipient');
            $target = $repository->findOneBy(array('username' => $targetname));
            dump($target);

            if($target!=NULL AND $targetname!=$currentuser->getUserIdentifier() AND $amount>0 AND $amount<$currentuser->getBalance()){
                $date = new \DateTime('@'.strtotime('now'));
                $transaction = new Transaction();
                $transaction->setDate($date);
                $transaction->setToUsername($targetname);
                $transaction->setAmount($amount);
                $transaction->setUser($currentuser);

                $senderbal = $currentuser->getBalance()-$amount;
                $targetbal = $target->getBalance()+$amount;

                $currentuser->setBalance($senderbal);
                $target->setBalance($targetbal);

                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->persist($transaction);
                $entitymanager->persist($currentuser);
                $entitymanager->persist($target);
                $entitymanager->flush();

                dump($target);
                dump($currentuser);
                return $this->redirectToRoute('app_confirmation', [
                    'amount' => $amount,
                    'to' => $targetname
                ]);
            } else if($amount<0){
                return new Response("How you do that?");
            } else if($amount>($currentuser->getBalance())){
                return new Response("Not enough money.");
            } else if($targetname==$currentuser->getUserIdentifier()){
                return new Response("You can't send money to yourself.");
            } else if($target==NULL){
                return new Response("Recipient doesn't exist.");
            }

        }
        return $this->render('send_money/index.html.twig', [
            'beneficiary' => $request->get('beneficiary'),
            'amount' => $request->get('amount'),
            'user' => $this->getUser(),
            'controller_name' => 'SendMoneyController',
        ]);
    }
}
