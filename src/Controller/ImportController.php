<?php

namespace App\Controller;

use App\Service\ImportHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    #[Route('/import', name: 'app_import_csv')]
    public function import(Request $request, ImportHandler $importHandler): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        if($importHandler->import_csv($file)) {
//            $this->addFlash('notice', 'flash_message.import_success');
        } else {
//            $this->addFlash('danger', 'flash_message.import_error');
        }

        return $this->redirectToRoute('app_home');
    }
}