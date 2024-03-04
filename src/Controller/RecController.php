<?php
#crud lena 
namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\RecType;
use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\Length;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Security\Core\Security;
use App\Repository\UserRepository;



class RecController extends AbstractController
{
    #[Route('/rec', name: 'app_rec')]
    public function index(): Response
    {$data = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        
        return $this->render('rec/index.html.twig', [
            'controller_name' => 'RecController',
            'list'=>$data
        ]);
    }
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
   
    #[Route('/rec/create', name: 'create')]
    public function create(Request $request , UserRepository $repository, Security $security)
    {

    $user = $security->getUser();

      $reclamation = new Reclamation();
      $reclamation->setUser($user);
      $form = $this->createForm(RecType::class, $reclamation);
      $formView = $form->createView();
    #  $form = $this->createForm(RecType::class, $reclamation, [
   #     'constraints' => [
   #        new Length(['min' => 10]),
  #      ] 
    # ]);
     $form->handleRequest($request);
     if($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($reclamation);
        $em->flush();

        return $this->redirectToRoute('app_rec');
     }
     return $this->render('rec/create.html.twig',[
        'form' => $formView,
    ]);
    }

    #[Route('/rec/update{idrec}', name: 'update')]
    public function update (Request $request,$idrec)
{   
    $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($idrec);
    $form = $this->createform(RecType::class, $reclamation);
    $form->handleRequest($request);
    $formView = $form->createView();
    if($form->isSubmitted() && $form->isValid()){
       $em = $this->getDoctrine()->getManager();
       $em->persist($reclamation);
       $em->flush();

       return $this->redirectToRoute('app_rec');
    }
    return $this->render('rec/update.html.twig',[
       'form' => $formView,
   ]);
}

#[Route('/rec/delete{idrec}', name: 'delete')]
public function delete($idrec){
    $data = $this->getDoctrine()->getRepository(Reclamation::class)->find($idrec);
    $em = $this->getDoctrine()->getManager();
    $em->remove($data);
    $em->flush();

    return $this->redirectToRoute('app_rec');
}

// #[Route('/backrec', name: 'app_backrec')]
//     public function indexBack(): Response
//     {$data = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        
//         return $this->render('back_home/backrec.html.twig', [
//             'controller_name' => 'RecController',
//             'list'=>$data,
//             'page_title' => 'PAGE_Reclamation',
//             'active_page' => 'PAGE_Reclamation',
//         ]);
//     }

#[Route('/backrec', name: 'app_backrec')]
public function indexBack(Request $request): Response
{
    $data = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();

    // Créez un adaptateur Pagerfanta pour vos données
    $adapter = new ArrayAdapter($data);

    // Créez une instance de Pagerfanta
    $pagerfanta = new Pagerfanta($adapter);

    // Configurez la page actuelle en fonction de la requête
    $pagerfanta->setCurrentPage($request->query->get('page', 1));

    // Définissez le nombre d'éléments par page
    $pagerfanta->setMaxPerPage(10); // Par exemple, 10 éléments par page

    // Récupérez les éléments de la page actuelle
    $currentPageResults = $pagerfanta->getCurrentPageResults();

    return $this->render('back_home/backrec.html.twig', [
        'controller_name' => 'RecController',
        'pager' => $pagerfanta,
        'list' => $currentPageResults,
        'page_title' => 'PAGE_Reclamation',
        'active_page' => 'PAGE_Reclamation',
    ]);
}

#[Route('/backrec/delete{idrec}', name: 'backdelete')]
public function backdelete($idrec){
    $data = $this->getDoctrine()->getRepository(Reclamation::class)->find($idrec);
    $em = $this->getDoctrine()->getManager();
    $em->remove($data);
    $em->flush();

    return $this->redirectToRoute('app_backrec');
}
#[Route('/showclaims', name: 'Claims_show')]
public function show(ReclamationRepository $rep, Request $request): Response
{
    // Retrieve search term and sort parameters from the request
    $searchTerm = $request->query->get('search', '');

    // Fetch claims based on search criteria and sort parameters
    $claims = $rep->findBySearchCriteriaAndSort($searchTerm);

    // Check if the request is an AJAX request
    if ($request->isXmlHttpRequest()) {
        // If AJAX request, render the part of the template for the table body
        return $this->render('rec/search.html.twig', [
            'list' => $claims,
            'searchTerm' => $searchTerm,
            
        ]);
    }

    // Render the full page for non-AJAX requests
    return $this->render('rec/index.html.twig', [
        'list' => $claims,
        'searchTerm' => $searchTerm,
        
    ]);
}

    #[Route('/mesRec', name: 'mes_rec')]
    public function mesReclama(ReclamationRepository $reclamationRepository,Security $security): Response
        {
            // Récupérer l'utilisateur actuellement authentifié
            $user = $security->getUser();

            // Récupérer les réclamations de l'utilisateur
            $reclamations = $reclamationRepository->findBy(['user' => $user]);

            return $this->render('rec/mesrec.html.twig', [
                'list' => $reclamations,
            ]);
        }


}