<?php


namespace App\Image;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImageUpload
{

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


}