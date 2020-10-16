<?php


namespace App\Normalizer;


use App\Entity\Sport;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class SportNormalizer implements ContextAwareNormalizerInterface
{

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
        return $data instanceof Sport;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);
        $data['pera'] = 'zika';

        // Here, add, edit, or delete some data:
        $data['href']['self'] = $this->router->generate('sport_single', [
            'id' => $object->getId(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        return $data;
    }
}