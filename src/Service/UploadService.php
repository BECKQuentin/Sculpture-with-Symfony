<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

class UploadService
{
    private $uploadImagesDirectory;
    
    public function __construct(string $uploadImageDirectory)
    {
        $this->uploadImagesDirectory = $uploadImageDirectory;
    }

    public function uploadImages(UploadedFile $images, $entity)
    {
        $fileName = $this->createFileName($images);

        $path = $this->uploadImagesDirectory . "/" . $entity->getImagesDirectory();
        $images->move($path, $fileName);

        return $fileName;
    }

    public function uploadImagesHome(UploadedFile $images)
    {
        $fileName = $this->createFileName($images);

        $path = $this->uploadImagesDirectory . "/" . "home";
        $images->move($path, $fileName);

        return $fileName;
    }

    private function createFileName(UploadedFile $file): string
    {
        $slugger = new AsciiSlugger();
        $fileName = $slugger->slug($file->getClientOriginalName())->lower();
        $fileName = explode('-', $fileName);
        $fileName = array_slice($fileName, 0, -1);
        $fileName = join('-', $fileName);
        $fileName .= '.' . uniqid() . '.' . $file->guessExtension();

        return $fileName;
    }
}