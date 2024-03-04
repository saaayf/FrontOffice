<?php

namespace App\Controller;

use App\Entity\Entretient;
use App\Form\Entretient2Type;
use App\Repository\EntretientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/entretientf')]
class EntretientfController extends AbstractController
{
    #[Route('/', name: 'app_entretientf_index', methods: ['GET'])]
    public function index(EntretientRepository $entretientRepository): Response
    {
        return $this->render('entretientf/index.html.twig', [
            'entretients' => $entretientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_entretientf_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entretient = new Entretient();
        $form = $this->createForm(Entretient2Type::class, $entretient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entretient);
            $entityManager->flush();

            return $this->redirectToRoute('app_entretientf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretientf/new.html.twig', [
            'entretient' => $entretient,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_entretientf_show', methods: ['GET'])]
    public function show(Entretient $entretient): Response
    {
        return $this->render('entretientf/show.html.twig', [
            'entretient' => $entretient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entretientf_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entretient $entretient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Entretient2Type::class, $entretient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entretientf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretientf/edit.html.twig', [
            'entretient' => $entretient,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_entretientf_delete', methods: ['POST'])]
    public function delete(Request $request, Entretient $entretient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entretient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($entretient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entretientf_index', [], Response::HTTP_SEE_OTHER);
    }
}
