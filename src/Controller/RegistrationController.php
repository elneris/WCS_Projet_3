<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Token;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Services\TokenSend;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenSend $tokenSend)
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $token = new Token($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($token);



            $media = new Media();
            $media->setName('MonAvatar');
            $media->setUrl('assets/img/avatar.jpg');
            $media->setType('avatar');
            $media->setUser($user);

            $entityManager->persist($media);

            $entityManager->flush();

            $tokenSend->sendToken($user, $token);

            $this->addFlash(
                'success',
                "Un email de confirmation vous a été envoyé, veuillez cliquer sur le lien présent dans l'email"
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirmation/{value}", name="token_validation")
     *
     */
    public function validateToken(Token $token, EntityManagerInterface $manager, Request $request)
    {
        $user = $token->getUser();

        if ($user->getEnable()) {
            $this->addFlash(
                'danger',
                "Ce token est déjà validé !"
            );

            return $this->redirectToRoute('app_login');
        }

        if ($token->isValid()) {
            $user->setEnable(true);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre inscription a bien été validé, vous pouvez vous connecter !"
            );

            return $this->redirectToRoute('app_login');
        }

        $manager->remove($token);
        $manager->flush();

        $this->addFlash(
            'notice',
            "Le token est expiré, Inscrivez-vous à nouveau"
        );

        return $this->redirectToRoute('app_register');
    }
}
