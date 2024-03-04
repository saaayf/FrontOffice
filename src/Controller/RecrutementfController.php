<?php

namespace App\Controller;

use App\Entity\Recrutement;
use App\Form\Recrutement1Type;
use App\Repository\RecrutementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recrutementf')]
class RecrutementfController extends AbstractController
{
    #[Route('/', name: 'app_recrutementf_index', methods: ['GET'])]
    public function index(RecrutementRepository $recrutementRepository): Response
    {
        return $this->render('recrutementf/index.html.twig', [
            'recrutements' => $recrutementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_recrutementf_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recrutement = new Recrutement();
        $form = $this->createForm(Recrutement1Type::class, $recrutement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recrutement);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_recrutementf_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('recrutementf/new.html.twig', [
            'recrutement' => $recrutement,
            'form' => $form->createView(), // Utilisez createView() pour obtenir la vue de formulaire
        ]);
    }

    #[Route('/{id}', name: 'app_recrutementf_show', methods: ['GET'])]
    public function show(Recrutement $recrutement): Response
    {
        return $this->render('recrutementf/show.html.twig', [
            'recrutement' => $recrutement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recrutementf_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recrutement $recrutement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Recrutement1Type::class, $recrutement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_recrutementf_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recrutementf/edit.html.twig', [
            'recrutement' => $recrutement,
            'form' => $form->createView(), // Utilisez createView() pour obtenir la vue de formulaire
        ]);
    }

    #[Route('/{id}', name: 'app_recrutementf_delete', methods: ['POST'])]
    public function delete(Request $request, Recrutement $recrutement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recrutement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recrutement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recrutementf_index', [], Response::HTTP_SEE_OTHER);
    }
}
