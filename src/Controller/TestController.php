<?php

namespace App\Controller;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;


class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(MailerInterface $mailer): Response
    {
        {
            // Create an email message
            $email = (new Email())
                ->from('sarah.henia@esprit.tn')
                ->to('sarah.henia@esprit.tn')
                ->subject('Test Email')
                ->text('This is a test email sent from Symfony Mailer Bundle.');
    
            // Send the email
            $mailer->send($email);
    
            // Return a response
            return new Response('Email sent successfully!');
        }
    }
}
