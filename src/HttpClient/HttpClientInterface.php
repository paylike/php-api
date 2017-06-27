<?php

namespace Paylike\HttpClient;

interface HttpClientInterface
{
    /**
     * Performs the underlying HTTP request. It takes care of handling the
     * connection errors, parsing the headers and the response body.
     *
     * @param  string $http_verb The HTTP verb to use: get, post
     * @param  string $method    The API method to be called
     * @param  array  $args      Assoc array of parameters to be passed
     *
     * @return \Paylike\Response\ApiResponse
     * @throws \Paylike\Exception\ApiException
     */
    public function request($http_verb, $method, $args = array());
}