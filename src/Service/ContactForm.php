<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Environment as Environment;

class ContactForm
{
    private $container;
    private $mailer;
    private $twig;

    public function __construct(ContainerInterface $container, \Swift_Mailer $mailer, Environment $twig)
    {
        $this->container = $container;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * *************************************************************
     * Send a contact mail
     * *************************************************************
     */
    public function sendMail($form)
    {
        $mail = (new \Swift_Message())
            ->setFrom('noreply@test.com')
            ->setTo('mickaeld_03@hotmail.fr')
//                ->setBcc('mickael@ab6net.net')
            ->setSubject('Demande de renseignement depuis le site TEST (www.test.com)')
            ->setBody($this->twig->render('Email/email.html.twig',['data' => $form->getData()]),'text/html');

        $this->mailer->send($mail);
    }

    /**
     * *************************************************************
     * Check if the Google's Recaptcha 2 is valid
     * *************************************************************
     */
    public function checkCaptcha($recaptcha): Bool
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array('secret'=> $this->container->getParameter('beelab_recaptcha2.secret'), 'response' => $recaptcha));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response);

        return $data->success;
    }
}