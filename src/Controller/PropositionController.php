<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Entity\Projet;
use App\Form\PropositionType;
use App\Repository\PropositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Security;

#[Route('/proposition')]
class PropositionController extends AbstractController
{
private $logger;
    private $security;

    public function __construct(LoggerInterface $logger ,Security $security)
    {
        $this->logger = $logger;
        $this->security = $security;
    }

    #[Route('/findbyprojet/{id_projet}', name: 'app_proposition_index', methods: ['GET'])]
    public function index($id_projet, PropositionRepository $propositionRepository): Response
    {
        return $this->render('proposition/index.html.twig', [
            'propositions' => $propositionRepository->findbyprojet($id_projet),
            "id_projet" => $id_projet
        ]);
    }
      #[Route('/back', name: 'app_proposition_index_back', methods: ['GET'])]
        public function indexBack(PropositionRepository $propositionRepository): Response
        {
            return $this->render('proposition/indexBack.html.twig', [
                'propositions' => $propositionRepository->findAll()

            ]);
        }

         #[Route('/findbyprojetMy/{id_projet}', name: 'app_proposition_index_My', methods: ['GET'])]
            public function indexMine($id_projet, PropositionRepository $propositionRepository): Response
            {
                return $this->render('proposition/Myindex.html.twig', [
                    'propositions' => $propositionRepository->findbyprojet($id_projet),
                    "id_projet" => $id_projet
                ]);
            }


    #[Route('/new/{id_projet}', name: 'app_proposition_new', methods: ['GET', 'POST'])]
    public function new($id_projet,Request $request, EntityManagerInterface $entityManager): Response
    {

            $iduser = $this->security->getUser()->getId();
             $this->logger->info("current user id = " . $iduser);
             $user = $this->security->getUser();
        $proposition = new Proposition();
        $form = $this->createForm(PropositionType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proposition->setIdProjet($entityManager->getRepository(Projet::class)->find($id_projet));
            $entityManager->persist($proposition);
             $proposition->setUser($user);
            $entityManager->flush();

             $sid = "AC31bb73eb632d06babca5d76d125861d9";
                    $token  = "c898343992c62300f56ab4051cc4d7c4";
                    $twilio = new Client($sid, $token);

                  /*  $message = $twilio->messages
                      ->create("+21696614020", // to
                        array(
                          "from" => "+14845145353",
                          "body" => "Une nouvelle postulation a été ajouté à votre projet !"
                        )
                      );*/

            return $this->redirectToRoute('app_proposition_index', ['id_projet' => $id_projet], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proposition/new.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
            'projet_id' => $id_projet
        ]);
    }

    #[Route('/{id}', name: 'app_proposition_show', methods: ['GET'])]
    public function show(Proposition $proposition): Response
    {
        return $this->render('proposition/show.html.twig', [
            'proposition' => $proposition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_proposition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PropositionType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_proposition_index', ['id_projet' => $proposition->getIdProjet()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proposition/edit.html.twig', [
            'proposition' => $proposition,
            'form' => $form,
            'projet_id' => $proposition->getIdProjet()->getId()
        ]);
    }
     #[Route('/{id}/editBack', name: 'app_proposition_edit_back', methods: ['GET', 'POST'])]
        public function editBack(Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
        {
            $form = $this->createForm(PropositionType::class, $proposition);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_proposition_index_back', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('proposition/editBack.html.twig', [
                'proposition' => $proposition,
                'form' => $form,
                'projet_id' => $proposition->getIdProjet()->getId()
            ]);
        }

    #[Route('/{id}/{id_projet}', name: 'app_proposition_delete', methods: ['POST'])]
    public function delete($id_projet,Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proposition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($proposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_proposition_index', ['id_projet' => $id_projet], Response::HTTP_SEE_OTHER);
    }
      #[Route('Deleteback/{id}', name: 'app_proposition_delete_back', methods: ['POST'])]
        public function deleteBack(Request $request, Proposition $proposition, EntityManagerInterface $entityManager): Response
        {
            if ($this->isCsrfTokenValid('delete'.$proposition->getId(), $request->request->get('_token'))) {
                $entityManager->remove($proposition);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_proposition_index_back', [], Response::HTTP_SEE_OTHER);
        }
}
