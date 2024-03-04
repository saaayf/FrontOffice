<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offer; // Import the Offer entity

class DownloadController extends AbstractController
{
    #[Route('/download/{id}', name: 'app_download_file')]
    public function download(int $id): Response
    {
        // Retrieve the offer entity from the database
        $offer = $this->getDoctrine()->getRepository(Offer::class)->find($id);

        // Check if the offer exists
        if (!$offer) {
            throw $this->createNotFoundException('Offer not found.');
        }

        // Retrieve the file name from the offer entity
        $fileName = $offer->getFileName();

        // Construct the full file path
        $filePath = $this->getParameter('upload_directory') . '/' . $fileName;

        // Check if the file exists
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('The file does not exist.');
        }

        // Create a BinaryFileResponse object to send the file to the client
        $response = new BinaryFileResponse($filePath);

        // Set the file name for the download
        $response->setContentDisposition(
            \Symfony\Component\HttpFoundation\ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );

        return $response;
    }
}
