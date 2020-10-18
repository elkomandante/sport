<?php


namespace App\ApiService\Sport;


use App\Entity\Sport;
use App\Exception\ViolationException;
use App\Image\ImageUpload;
use App\Repository\LeagueRepository;
use App\Repository\SportRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class SportService implements ServiceSubscriberInterface
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
        $violations = $this->locator->get(ValidatorInterface::class)->validate($sport);
        if(count($violations) !== 0) throw new ViolationException($violations);
        $sport->setId(time());

        $sport->setThumbnailImage($this->locator->get(ImageUpload::class)->uploadBase64Image(
            $sport->getThumbnailImage(),
            Sport::imageDir
        ));
        $this->locator->get(SportRepository::class)->saveSport($sport);
        return $sport;
    }

    public static function getSubscribedServices()
    {
        return [
            SportRepository::class => SportRepository::class,
            LeagueRepository::class => LeagueRepository::class,
            ImageUpload::class => ImageUpload::class,
            ValidatorInterface::class => ValidatorInterface::class
        ];
    }
}