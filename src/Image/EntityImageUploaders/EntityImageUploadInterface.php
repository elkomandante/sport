<?php


namespace App\Image\EntityImageUploaders;


interface EntityImageUploadInterface
{
    public function upload(ImageUploadInterface $imageUpload, $entity);
}