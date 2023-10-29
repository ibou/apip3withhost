<?php

namespace App\Service\Docker\Exception;

class PutContainerArchiveForbiddenException extends ForbiddenException
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
        parent::__construct('Permission denied, the volume or container rootfs is marked as read-only.');
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
