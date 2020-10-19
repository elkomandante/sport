<?php


namespace App\Image\EntityImageUploaders;


use App\Entity\Sport;

class SportImageUploader implements EntityImageUploadInterface
{
    /**
     * @param ImageUploadInterface $imageUpload
     * @param $sport Sport
     */
    public function upload(ImageUploadInterface $imageUpload, $sport)
    {
        $sport->setThumbnailImage($imageUpload->uploadBase64Image(
            $sport->getThumbnailImageData(),
            Sport::imageDir
        ));

        $sport->setThumbnailGreenImage(
            $imageUpload->uploadBase64Image(
                $sport->getThumbnailImageGreenData(),
                Sport::imageDir
            )
        );
    }
}