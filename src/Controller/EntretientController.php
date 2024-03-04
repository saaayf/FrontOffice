<?php

namespace App\Controller;

use App\Entity\Entretient;
use App\Form\Entretient1Type;
use App\Repository\EntretientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/entretient')]
class EntretientController extends AbstractController
{
    #[Route('/', name: 'app_entretient_index', methods: ['GET'])]
    public function index(EntretientRepository $entretientRepository): Response
    {
        return $this->render('entretient/index.html.twig', [
            'entretients' => $entretientRepository->findAll(),
            'page_title' => 'PAGE_Entretien',
            'active_page' => 'PAGE_Entretien',
        ]);
    }

    #[Route('/new', name: 'app_entretient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entretient = new Entretient();
        $form = $this->createForm(Entretient1Type::class, $entretient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entretient);
            $entityManager->flush();

            return $this->redirectToRoute('app_entretient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretient/new.html.twig', [
            'entretient' => $entretient,
            'form' => $form->createView(),
            'page_title' => 'PAGE_Entretien',
            'active_page' => 'PAGE_Entretien',
        ]);
    }

    #[Route('/{id}', name: 'app_entretient_show', methods: ['GET'])]
    public function show(Entretient $entretient): Response
    {
        return $this->render('entretient/show.html.twig', [
            'entretient' => $entretient,
            'page_title' => 'PAGE_Entretien',
            'active_page' => 'PAGE_Entretien',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entretient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entretient $entretient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Entretient1Type::class, $entretient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entretient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretient/edit.html.twig', [
            'entretient' => $entretient,
            'form' => $form->createView(),
            'page_title' => 'PAGE_Entretien',
            'active_page' => 'PAGE_Entretien',
        ]);
    }

    #[Route('/{id}', name: 'app_entretient_delete', methods: ['POST'])]
    public function delete(Request $request, Entretient $entretient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entretient->getId(), $request->request->get('_token'))) {
            $entityManager->remove($entretient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entretient_index', [], Response::HTTP_SEE_OTHER);
    }
}
