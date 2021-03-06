<?php

namespace App\Controller;

use App\Entity\Domain;
use App\Form\DomainType;
use App\Repository\DomainRepository;
use App\Services\ActivityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/metier")
 */
class DomainController extends AbstractController
{
    /**
     * @Route("/index/{page}", requirements={"page" = "\d+"}, name="domain_index", methods={"GET"})
     */
    public function index(int $page, DomainRepository $domainRepository): Response
    {
        $maxByPage = $this->getParameter('max_page');
        $domains = $domainRepository->findAllPaginationAndTrie($page, $maxByPage);

        $pagination = [
            'page' => $page,
            'nbPages' => ceil(count($domains) / $maxByPage),
            'nameRoute' => 'domain_index',
            'paramsRoute' => []
        ];

        return $this->render('domain/index.html.twig', [
            'domains' => $domains,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/ajouter", name="domain_new", methods={"GET","POST"})
     */
    public function new(Request $request, ActivityManager $activityManager): Response
    {
        $domain = new Domain();
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($activityManager->domainExist($domain)) {
                $this->addFlash(
                    'danger',
                    'Le métier existe déjà'
                );
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($domain);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Le métier a bien été ajouté'
                );

                return $this->redirectToRoute('domain_index', ['page' => 1]);
            }
        }

        return $this->render('domain/new.html.twig', [
            'domain' => $domain,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editer", name="domain_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Domain $domain): Response
    {
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('domain_index', [
                'page' => 1,
            ]);
        }

        return $this->render('domain/edit.html.twig', [
            'domain' => $domain,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="domain_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Domain $domain): Response
    {
        if ($this->isCsrfTokenValid('delete'.$domain->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($domain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('domain_index', ['page' => 1]);
    }
}
