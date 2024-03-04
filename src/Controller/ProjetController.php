<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

#[Route('/projet')]
class ProjetController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    #[Route('/', name: 'app_projet_index', methods: ['GET'])]
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }
    #[Route('/front', name: 'app_projet_index_front', methods: ['GET'])]
        public function indexFront(ProjetRepository $projetRepository , Request $request , PaginatorInterface $paginator): Response
        {
         $query = $projetRepository->findAll();
             // Handle search
             $searchQuery = $request->query->get('q');
             if (!empty($searchQuery)) {
                  $query = $projetRepository->findByExampleField($searchQuery);
             }
             $projets = $paginator->paginate(
                 $query,
                 $request->query->getInt('page', 1), // Current page number
                 3 // Number of items per page
             );
             if ($request->isXmlHttpRequest()) {
                   $paginationHtml = $this->renderView('projet/_paginator.html.twig', ['projets' => $projets]);
                         $contentHtml = $this->renderView('projet/_project_list.html.twig', ['projets' => $projets]);
                    // Log to verify if the controller enters this condition
                            $this->logger->info('Request is AJAX');
                    return new JsonResponse([
                         'content' => $contentHtml,
                         'pagination' => $paginationHtml
                         ]);
            } else {
             // Log to verify if the controller enters this condition
            $this->logger->info('Request is not AJAX');
             }
             return $this->render('projet/indexFront.html.twig', [
                 'projets' => $projets,
             ]);
        }

    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_index_front', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }
    #[Route('/{id}/front', name: 'app_projet_show_front', methods: ['GET'])]
        public function showFront(Projet $projet): Response
        {
            return $this->render('projet/showFront.html.twig', [
                'projet' => $projet,
            ]);
        }

    #[Route('/{id}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }
     #[Route('/{id}/editFront', name: 'app_projet_edit_front', methods: ['GET', 'POST'])]
        public function editFront(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
        {
            $form = $this->createForm(ProjetType::class, $projet);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_projet_index_front', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('projet/editFront.html.twig', [
                'projet' => $projet,
                'form' => $form,
            ]);
        }


    #[Route('/{id}', name: 'app_projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_projet_index_front', [], Response::HTTP_SEE_OTHER);
    }
}
