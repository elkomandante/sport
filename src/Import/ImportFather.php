<?php


namespace App\Import;


use App\Image\ImageUpload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImportFather
{
    /**
     * @var HttpClientInterface
     */
    protected $client;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var ImageUpload
     */
    protected $imageUpload;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager,ImageUpload $imageUpload)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->imageUpload = $imageUpload;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}