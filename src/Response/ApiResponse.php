<?php


namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiResponse
{

    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var JsonDecode
     */
    private $decode;

    public function __construct(SerializerInterface $serializer, DecoderInterface $decode)
    {
        $this->serializer = $serializer;
        $this->decode = $decode;
    }

    public function generateResponse($data, array $params)
    {

        $serializerParams = [];
        if(isset($params[AbstractNormalizer::GROUPS])) $serializerParams[AbstractNormalizer::GROUPS] = $params[AbstractNormalizer::GROUPS];

        $data = $this->serializer->serialize($data,'json', $serializerParams);

        $responseData = [
            'data' => $this->decode->decode($data,'json')
        ];

        return new JsonResponse($responseData);

    }


}