<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    public function upload(UploadedFile $file, $targetDirecory)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($targetDirecory, $fileName);

        return $fileName;
    }
}
