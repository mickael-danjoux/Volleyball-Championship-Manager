<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ContactForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;
use Symfony\Component\HttpKernel\CacheClearer;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ContactForm $contactService): Response
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact);

        if (($request->isMethod('POST')) && ($form->handleRequest($request)->isValid()) && ($form->get('agreeTerms')->getData() == true))
        {
            // Si le captcha est invalide alors...
            if (!$contactService->checkCaptcha($request->get('g-recaptcha-response')))
            {
                $this->addFlash('success', 'Votre mail a bien été envoyé, notre équipe vous répondra dès que possible.');
                return $this->redirect($this->generateUrl('contact'));
            }

            else
            {
                $contactService->sendMail($form);
                $this->addFlash('success', 'Votre mail a bien été envoyé, notre équipe vous répondra dès que possible.');
                return $this->redirect($this->generateUrl('contact'));
            }
        }

        return $this->render('front/contact.html.twig', ['contact' => $form->createView()]);
    }

    /**
     * @Route("/verification-captcha", name="contact_check_captcha")
     */
    public function checkCaptchaAction($recaptcha): Bool
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array('secret' => $this->getParameter('beelab_recaptcha2.secret'), 'response' => $recaptcha));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);

        return $data->success;
    }

    /**
     * Mentions Légales
     * @Route("/mentions-legales", name="mentions_legales");
     */
    public function mentionLegalesAction(Client $client)
    {
        $siteUrl = null;
        if (getenv('APP_ENV') != 'prod'){
            $siteUrl = "www.garage-carriat.com";
        }else{
            $siteUrl = $_SERVER['HTTP_HOST'];
        }        

        $URL = 'http://intranet.ab6net.net/mentions/mentions-perso.html?url=' . $siteUrl;
        $response = $client->get($URL);

        if ($response->getStatusCode() == Response::HTTP_OK) {
            $resultat = $response->getBody();
        }

        $retour = json_decode($resultat, true);

        return $this->render('legales/legales.html.twig', [
            'siteUrl' => $siteUrl,
            'client' => $retour["client"],
            'hebergeur' => $retour["hebergeur"],
            'ab6net' => $retour["ab6net"],
        ]);
    }
    /**
     *
     * @Route("/clearcache")
     */
    public function cacheClear()
    {
        $fs = new Filesystem();
        $result = false;

        try {
            $fs->remove(__DIR__ . '/../../var/cache/');
            $result = true;
        } catch(Exception $e) {
            $result = $e;
        }

        echo $result;

        return new \Symfony\Component\HttpFoundation\JsonResponse(['result' => $result], 200);
    }

}
