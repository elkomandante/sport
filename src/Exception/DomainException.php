<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class DomainException extends HttpException
{
    public function __construct(
        $message,
        int $statusCode = 400,
        \Throwable $previous = null,
        array $headers = [],
        ?int $code = 0
    ) {
        $message = ['errors' => $message];
        $message = json_encode($message);

        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
