<?php


namespace App\Image;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImageUpload
{

    const validMimeTypes = [
        "image/jpeg",
        "image/png",
        "image/jpg"
    ];

    private $assetsDir;
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct($assetsDir,HttpClientInterface $client)
    {
        $this->assetsDir = $assetsDir;
        $this->client = $client;
    }

    public function uploadImage($imageUrl,$imageDir)
    {
        try {
            $response = $this->client->request('GET', $imageUrl);

            $image = $response->getContent();
        }catch (\Exception $e){
            echo $e->getMessage();
            return "";
        }


        file_put_contents($this->assetsDir.$imageDir."/".basename($imageUrl),$image);

        return basename($imageUrl);

    }

    public function uploadBase64Image($base64Image, $imageDir)
    {
        if(empty($base64Image)) return "";
        $tmpPath = sys_get_temp_dir()."/".uniqid();
        $imageData = explode(',',$base64Image);

        if(strpos($imageData[0],'base64') === false){
            throw new FileException();
        }

        file_put_contents($tmpPath,base64_decode($imageData[1]));

        $file = new File($tmpPath);

        if(!in_array($file->getMimeType(),self::validMimeTypes)){
            throw new FileException('Bad image sent.');
        }

        $fileName = $file->getFilename().".".$file->guessExtension();
        $file->move($this->assetsDir.$imageDir, $fileName);

        return $fileName;
    }


}