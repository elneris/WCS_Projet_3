<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Link;
use App\Entity\Media;
use App\Entity\User;
use App\Form\LinkType;
use App\Form\UserType;
use App\Form\ActivityType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/{id}", name="user_index", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function index(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="user_show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->render('user/show.html.twig');
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->remove('password');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [
                'id' => $user->getId(),
            ]);
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit_activities", name="user_edit_activities", methods={"GET","POST"})
     * @param Request $request
     * @param Activity $activity
     * @return Response
     */

    public function editActivities(Request $request, Activity $activity, User $user): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($activity);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [
                'id' => $activity->getId(),
            ]);
        }

        return $this->render('user/edit_activities.html.twig', [
            'activity' => $activity,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit_links", name="user_edit_links", methods={"GET","POST"})
     * @param Request $request
     * @param Link $links
     * @return Response
     */

    public function editLinks(Request $request, Link $links, User $user): Response
    {
        $form = $this->createForm(LinkType::class, $links);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($links);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [
                'id' => $links->getId(),
            ]);
        }

        return $this->render('user/edit_links.html.twig', [
            'links' => $links,
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
