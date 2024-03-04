<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Reponse;
use App\Form\ReponseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\DBAL\Types\TextType;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Length;
use Dompdf\Dompdf;

class ReponseController extends AbstractController
{
    #[Route('/reponse', name: 'reponse_index')]
    public function index(): Response
    {
        $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findAll();

        return $this->render('reponse/index.html.twig', [
            'list' => $reponses,
        ]);
    }

    #[Route('/reponse/create{id}', name: 'reponse_create')]
    public function create(Request $request , $id): Response
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $reponse = new Reponse();
        $reponse->setCreatedAt(new \DateTime()); // Set the current date and time
        $reponse->setReclamation($reclamation);
        $form = $this->createForm(ReponseType::class, $reponse);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reponse);
            $entityManager->flush();

            return $this->redirectToRoute('reponse_index');
        }

        return $this->render('reponse/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/reponse/delete{id}', name: 'delete_reponse')]
    public function delete($id){
        $data = $this->getDoctrine()->getRepository(Reponse::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        return $this->redirectToRoute('reponse_index');
    }

    #[Route('/reponse/update{idrep}', name: 'update_reponse')]
    public function update (Request $request,$idrep)
    {   
        $reponse = $this->getDoctrine()->getRepository(Reponse::class)->find($idrep);
        $reponse->setCreatedAt(new \DateTime()); 

        $form = $this->createform(ReponseType::class, $reponse);
        $form->handleRequest($request);
        $formView = $form->createView();
        if($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($reponse);
        $em->flush();

        return $this->redirectToRoute('reponse_index');
        }
        return $this->render('reponse/update.html.twig',[
        'form' => $formView,
    ]);
    }

   

    #[Route('/reponse/back', name: 'reponse_back')]
    public  function affichageback(): Response
    {
    $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findAll();

    return $this->render('back_home/backrep.html.twig', [
        'list' => $reponses,
        'page_title' => 'PAGE_Reponse',
        'active_page' => 'PAGE_Reponse',
    ]);

    }

    #[Route('/reponseback/delete{id}', name: 'delete_back')]
    public function deleteback($id){
        $data = $this->getDoctrine()->getRepository(Reponse::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($data);
        $em->flush();

        return $this->redirectToRoute('reponse_back');
    }


    #[Route('/reponse/pdf', name: 'generate_pdf')]
    public function generatePdf(): Response
    {
        // Récupérez les données nécessaires depuis la base de données
        $reponses = $this->getDoctrine()->getRepository(Reponse::class)->findAll();

        // Rendez la vue Twig pour le PDF en passant les données
        $html = $this->renderView('back_home/pdf.html.twig', [
            'list' => $reponses,
            'page_title' => 'PAGE_Reponse',
        'active_page' => 'PAGE_Reponse',
        ]);

        // Créez une instance de Dompdf
        $dompdf = new Dompdf();

        // Chargez le contenu HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Générez le PDF
        $dompdf->render();

        // Renvoyez le PDF en réponse
        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }



   
}
