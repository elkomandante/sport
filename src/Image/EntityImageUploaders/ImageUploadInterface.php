<?php


namespace App\Image\EntityImageUploaders;


interface ImageUploadInterface
{
    public function uploadImage($imageUrl,$imageDir);
    public function uploadBase64Image($base64Image, $imageDir);
}