<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BackHomeController extends AbstractController
{
    
    #[Route('/back/home', name: 'app_back_home')]
    public function index(): Response
    {
        return $this->render('back_home/index.html.twig', [
            'controller_name' => 'BackHomeController',
            'page_title' => 'PAGE_ADMIN',
            'active_page' => 'PAGE_ADMIN',


        ]);
    }

   
}