<?php

namespace App\Controller;
use App\Entity\User; 
use App\Form\VerificationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends AbstractController
{
    /*
    #[Route('/verify-email', name: 'app_verify_email')]
    public function verifyEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User|null $user */
        /*
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('User not found.');
        }

        if ($user->isVerified()) {
            $this->addFlash('success', 'Your email address is already verified.');
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(VerificationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enteredCode = $form->get('code')->getData();

            if ($enteredCode === $user->getVerificationCode()) {
                $user->setIsVerified(true);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Your email address has been verified.');
                return $this->redirectToRoute('app_home');
            } else {
                $this->addFlash('error', 'Invalid verification code. Please try again.');
            }
        }

        return $this->render('registration/verify_email.html.twig', [
            'verificationForm' => $form->createView(),
            'user' => $user,
        ]);
        
    }
#[Route('/email')]
public function sendEmail(MailerInterface $mailer): Response
{
    $email = (new Email())
        ->from('mailtrap@example.com')
        ->to('newuser@example.com')
        ->cc('mailtrapqa@example.com')
        ->addCc('staging@example.com')
        ->bcc('mailtrapdev@example.com')
        ->replyTo('mailtrap@example.com')
        ->priority(Email::PRIORITY_HIGH)
        ->subject('Time for Symfony Mailer!')
        ->text('Sending emails is fun again!')
        ->html('<p>See Twig integration for better HTML integration!</p>');

    $mailer->send($email);

    return new Response('Email was sent');
}
*/
}
