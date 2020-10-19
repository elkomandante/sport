<?php


namespace App\ApiService\Sport;


use App\ApiService\ApiServiceParent;
use App\Entity\Sport;
use App\Image\EntityImageUploaders\SportImageUploader;
use App\Image\ImageUpload;
use App\Repository\LeagueRepository;
use App\Repository\SportRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class SportService extends ApiServiceParent implements ServiceSubscriberInterface
{

    /**
     * @var ContainerInterface
     */
    private $locator;


    public function __construct(ContainerInterface $locator)
    {
        $this->locator = $locator;
    }

    public function getAllSports()
    {
        return $this->locator->get(SportRepository::class)->findAll();
    }

    public function getLeaguesBySport($sportId)
    {
        return $this->locator->get(LeagueRepository::class)->getLeaguesBySport($sportId);
    }

    public function savePost(Sport $sport)
    {
        $this->validate($this->locator->get(ValidatorInterface::class),$sport);
        $sport->setId(time());

        $this->locator->get(SportImageUploader::class)->upload(
           $this->locator->get(ImageUpload::class),
           $sport
        );

        $this->locator->get(SportRepository::class)->saveSport($sport);
        return $sport;
    }

    public function deleteSport(Sport $sport)
    {
        $this->locator->get(SportRepository::class)->deleteSport($sport);
    }

    public function updateSport(Sport $sport)
    {
        $this->validate($this->locator->get(ValidatorInterface::class),$sport);

        $this->locator->get(SportImageUploader::class)->upload(
            $this->locator->get(ImageUpload::class),
            $sport
        );

        $this->locator->get(SportRepository::class)->flush();
    }

    public static function getSubscribedServices()
    {
        return [
            SportRepository::class => SportRepository::class,
            LeagueRepository::class => LeagueRepository::class,
            ImageUpload::class => ImageUpload::class,
            ValidatorInterface::class => ValidatorInterface::class,
            SportImageUploader::class => SportImageUploader::class
        ];
    }
}