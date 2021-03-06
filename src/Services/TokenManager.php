<?php


namespace App\Services;

use App\Entity\Token;
use App\Entity\User;

class TokenManager
{
    private $mailer;

    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send(User $user, Token $token)
    {
        $message = (new \Swift_Message('Validez votre inscription'))
            ->setFrom('ratonsguincheur@admin.com')
            ->setTo($user->getEmail());

        $img = $message->embed(\Swift_Image::fromPath('assets/img/logo_lesratons.png'));


        $message->setBody(
            $this->twig
                ->render(
                    'emails/registration.html.twig',
                    [
                        'token' => $token->getValue(),
                        'img' => $img
                    ]
                ),
            'text/html'
        );
        $this->mailer->send($message);
    }
}
