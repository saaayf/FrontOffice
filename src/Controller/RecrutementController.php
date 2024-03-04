<?php

namespace App\Controller;

use App\Entity\Recrutement;
use App\Form\RecrutementType;
use App\Repository\RecrutementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recrutement')]
class RecrutementController extends AbstractController
{
    #[Route('/', name: 'app_recrutement_index', methods: ['GET'])]
    public function index(RecrutementRepository $recrutementRepository): Response
    {
        return $this->render('recrutement/index.html.twig', [
            'recrutements' => $recrutementRepository->findAll(),
            'page_title' => 'PAGE_Recrutement',
            'active_page' => 'PAGE_Recrutement',
        ]);
    }

    #[Route('/new', name: 'app_recrutement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recrutement = new Recrutement();
        $form = $this->createForm(RecrutementType::class, $recrutement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recrutement);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_recrutement_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('recrutement/new.html.twig', [
            'recrutement' => $recrutement,
            'form' => $form->createView(), // Pass the form view
            'page_title' => 'PAGE_Recrutement',
            'active_page' => 'PAGE_Recrutement',
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_recrutement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recrutement $recrutement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecrutementType::class, $recrutement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_recrutement_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('recrutement/edit.html.twig', [
            'recrutement' => $recrutement,
            'form' => $form->createView(), // Pass the form view
            'page_title' => 'PAGE_Recrutement',
            'active_page' => 'PAGE_Recrutement',
        ]);
    }
    

    #[Route('/{id}', name: 'app_recrutement_show', methods: ['GET'])]
    public function show(Recrutement $recrutement): Response
    {
        return $this->render('recrutement/show.html.twig', [
            'recrutement' => $recrutement,
            'page_title' => 'PAGE_Recrutement',
            'active_page' => 'PAGE_Recrutement',
        ]);
    }

   
    #[Route('/{id}', name: 'app_recrutement_delete', methods: ['POST'])]
    public function delete(Request $request, Recrutement $recrutement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recrutement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recrutement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recrutement_index', [], Response::HTTP_SEE_OTHER);
    }
}
