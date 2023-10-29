<?php

namespace App\Service\Docker\Exception;

class ServiceDeleteInternalServerErrorException extends InternalServerErrorException
{
    /**
     * @var \App\Service\Docker\Model\ErrorResponse
     */
    private $errorResponse;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;

    public function __construct(\App\Service\Docker\Model\ErrorResponse $errorResponse, \Psr\Http\Message\ResponseInterface $response)
    {
        parent::__construct('server error');
        $this->errorResponse = $errorResponse;
        $this->response = $response;
    }

    public function getErrorResponse(): \App\Service\Docker\Model\ErrorResponse
    {
        return $this->errorResponse;
    }

    public function getResponse(): \Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
}
