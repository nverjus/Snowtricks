<?php
namespace App\Service;

class Mailer
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendAccountActivationEmail($user, $body)
    {
        $message = (new \Swift_Message('Snowtricks, account activation'))
          ->setFrom('nverjus@gmail.com')
          ->setTo($user->getEmail())
          ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public function sendResetPasswordEmal($user, $body)
    {
        $message = (new \Swift_Message('Snowtricks, reset password'))
                    ->setFrom('nverjus@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}
