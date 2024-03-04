<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

#[Route('/listUsers', name: 'app_admin')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function admin(): Response
    {
        // Fetch user data from your data source (e.g., database)
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepository->findAll();

        return $this->render('user/show.html.twig', [
            'controller_name' => 'BackHomeController',
            'users' => $users,
            'page_title' => 'Users',
            'active_page' => 'Users list',


        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(
        ManagerRegistry $mr,
        UserRepository $repo,
        Request $req,
        UserPasswordEncoderInterface $passwordEncoder,
        int $id
    ): Response {
        $user = $repo->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password before persisting
            $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            $em = $mr->getManager();
            $em->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('user/edit.html.twig', [
            'f' => $form->createView(),
            'user' => $user,
            'page_title' => 'Users',
            'active_page' => 'Users list',


        ]);
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(UserRepository $repo, $id, ManagerRegistry $mr): Response
    {
        $user = $repo->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $em = $mr->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_admin');
    }

    
    #[Route('/add', name: 'add')]
    public function add(
        ManagerRegistry $mr,
        UserRepository $repo,
        Request $req,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $user = new User();
   
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password before persisting
            $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            $em = $mr->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('user/addUser.html.twig', [
            'f' => $form->createView(),
            'page_title' => 'Users',
            'active_page' => 'Users list',


        ]);
    }

    #[Route('/front/listeprofile', name: 'list_profile_front')]
    public function listuserFront(UserRepository $repository, Security $security)
    {
    // Récupérer l'utilisateur actuellement connecté
        $user = $security->getUser();

        if ($user) {
        // Récupérer les données de l'utilisateur actuel
        $user = $repository->findBy(['id' => $user]);
    }   else {
        // Gérer le cas où l'utilisateur n'est pas connecté si nécessaire
        $user = [];
    }

        return $this->render("front_home/profile.html.twig",
             ['tabuser' => $user]
    );
}
}