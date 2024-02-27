<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Expense;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    /**
     * @Route("/import", name="app_import_csv")
     */
    public function import(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $em): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        $file->move('./import', $file->getClientOriginalName());
        $csvpath = './import/'.$file->getClientOriginalName();
//        $csvpath = './public/import'.$file->getFilename()
//        dd($file);
        if (($handle = fopen($csvpath, 'r')) !== false) {
            $row = 0;
            $categories = [];
            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                $row++;
                if(1 == $row) {
                    continue;
                }
                $date = date_create_immutable_from_format('d/m/Y', $data[0]);
                $amount = (float) preg_replace('/(\d+),(\d\d)€/', '$1.$2', str_replace(' ','',$data[1]));
                $categoryName = $data[2];
                $description = $data[3];
                $isCash = (bool) $data[4];
                $isGain = (bool) $data[5];
                if(!$date) {
                    dd($data);
                }
                $expense = (new Expense())
                    ->setDate($date)
                    ->setAmount($amount)
                    ->setDescription($description)
                    ->setIsCash($isCash)
                    ->setIsGain($isGain);

                $category = $categories[$categoryName] ?? $categoryRepository->findOneBy(['name' => $categoryName]);
                if(is_null($category)) {
                    $category = (new Category())->setName($categoryName);
                    $categories[$categoryName] = $category;
                    $em->persist($category);
                }
                $expense->setCategory($category);
                $em->persist($expense);
            }
            $em->flush();
            dump($row);
        }
        return $this->redirectToRoute('app_home');
    }
}