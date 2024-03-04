<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private MailerInterface $mailer;
    private string $senderEmail;

    public function __construct(MailerInterface $mailer, string $senderEmail)
    {
        $this->mailer = $mailer;
        $this->senderEmail = $senderEmail;
    }

    public function sendRegistrationCode(string $recipientEmail, string $code): void
    {
        $email = (new Email())
            ->from($this->senderEmail)
            ->to($recipientEmail)
            ->subject('Code de vérification d\'inscription')
            ->text('Votre code de vérification est : ' . $code);

        $this->mailer->send($email);
    }
}
