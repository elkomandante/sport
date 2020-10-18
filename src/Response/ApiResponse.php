<?php


namespace App\Response;

use Knp\Component\Pager\PaginatorInterface;
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
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(SerializerInterface $serializer, DecoderInterface $decode,PaginatorInterface $paginator)
    {
        $this->serializer = $serializer;
        $this->decode = $decode;
        $this->paginator = $paginator;
    }

    public function generateResponse($data, array $params)
    {

        $serializerParams = [];
        if(isset($params[AbstractNormalizer::GROUPS])) $serializerParams[AbstractNormalizer::GROUPS] = $params[AbstractNormalizer::GROUPS];

        $page = (isset($params['page']) && $params['page'] > 0) ? $params['page'] : 1;
        $limit = (isset($params['limit']) && $params['limit'] > 0) ? $params['limit'] : 100;

        $paginated = $this->paginator->paginate($data,$page,$limit);

        $data = $this->serializer->serialize($paginated->getItems(),'json', $serializerParams);

        $responseData = [
            'data' => $this->decode->decode($data,'json'),
            'timestamp' => time(),
            'page' => $paginated->getCurrentPageNumber(),
            'per_page' => $paginated->getItemNumberPerPage(),
            'total' => $paginated->getTotalItemCount(),
        ];

        return new JsonResponse($responseData);

    }


}