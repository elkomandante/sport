<?php


namespace App\Normalizer;


use App\Controller\UserController;
use App\Entity\League;
use App\Entity\Sport;
use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SportNormalizer implements ContextAwareNormalizerInterface
{
    const singleEndpoints = [
        Sport::class => 'sport_single',
        League::class => 'league_single',
        User::class => UserController::singleRoute
    ];

    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    /**
     * @var ObjectNormalizer
     */
    private $normalizer;

    public function __construct(UrlGeneratorInterface $router, ObjectNormalizer $normalizer)
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Sport || $data instanceof League || $data instanceof User;
    }

    public function normalize($object, string $format = null, array $context = [])
    {

        $data = $this->normalizer->normalize($object, $format, $context);

        // Here, add, edit, or delete some data:
        $data['href']['self'] = $this->router->generate(self::singleEndpoints[get_class($object)], [
            'id' => $object->getId(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        return $data;
    }
}