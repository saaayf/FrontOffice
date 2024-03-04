<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OfferRepository;

class HelloController extends AbstractController
{
    #[Route('/', name: 'front_offers')]
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('Front/offer/index.html.twig', [
            'offers' => $offerRepository->findAll()
        ]);
    }
}
