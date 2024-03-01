<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Expense;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class ImportHandler {
    public function __construct(
        private CategoryRepository     $categoryRepository,
        private EntityManagerInterface $em
    ) {}

    public function import_csv(?UploadedFile $file): bool {
        if(!($file instanceof UploadedFile)) {
            return false;
        }
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
                if(!$date) {
                    //dd($data);
                    return false;
                }

                $amount = preg_replace('/\x{202F}/u', ' ', $data[1]);//weird space char from Google Sheet
                $amount = str_replace(' ','',$amount);
                $amount = (float) preg_replace('/(\d+),(\d\d)€/u', '$1.$2', $amount);

                $categoryName = $data[2];
                $description = $data[3];
                $isCash = (bool) $data[4];
                $isGain = (bool) $data[5];

                $expense = (new Expense())
                    ->setDate($date)
                    ->setAmount((float) $amount)
                    ->setDescription($description)
                    ->setIsCash($isCash)
                    ->setIsGain($isGain);

                $category = $categories[$categoryName] ?? $this->categoryRepository->findOneBy(['name' => $categoryName]);
                if(is_null($category)) {
                    $category = (new Category())->setName($categoryName);
                    $categories[$categoryName] = $category;
                    $this->em->persist($category);
                }
                $expense->setCategory($category);
                $this->em->persist($expense);
            }
            $this->em->flush();
            //dump($row);
        }
        return true;
    }
}