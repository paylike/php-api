<?php

namespace Paylike\Exception;

/**
 * Class ApiError
 *
 * @package Paylike\Exception
 */
class ApiException extends \Exception
{
    public $http_status;
    public $http_body;
    public $json_body;
    public $http_headers;

    public function __construct(
        $message,
        $http_status = null,
        $http_body = null,
        $json_body = null,
        $http_headers = null
    ) {
        parent::__construct($message);
        $this->http_status  = $http_status;
        $this->http_body    = $http_body;
        $this->json_body    = $json_body;
        $this->http_headers = $http_headers;
    }

    public function getHttpStatus()
    {
        return $this->http_status;
    }

    public function getHttpBody()
    {
        return $this->http_body;
    }

    public function getJsonBody()
    {
        return $this->json_body;
    }

    public function getHttpHeaders()
    {
        return $this->http_headers;
    }
}
