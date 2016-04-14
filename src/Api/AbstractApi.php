<?php

namespace Paylike\Api;

use Http\Client\HttpClient;
use Paylike\Exception\PaylikeException;
use Paylike\Paylike;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApi
{
    protected $client;

    /**
     * Constructor.
     *
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Build the final URL to send the request to.
     *
     * @param string $uri
     *
     * @return string
     */
    protected function buildUrl($uri)
    {
        if (substr($uri, 0, 1) !== '/') {
            $uri = '/'.$uri;
        }

        return Paylike::BASE_URL.$uri;
    }

    /**
     * Process the response.
     *
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function processResponse(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode > 299) {
            throw new PaylikeException(sprintf('Something went wrong with Paylike. Status code: %s. Reason: %s', $statusCode, $response->getReasonPhrase()));
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Send a request to the Paylike API.
     *
     * @param string $method
     * @param string $uri
     * @param array  $headers
     * @param string $body
     *
     * @return ResponseInterface
     */
    protected function send($method, $uri, array $headers = [], $body = null)
    {
        return $this->client->sendRequest($this->messageFactory->createRequest(
            $method,
            $uri,
            $headers,
            $body
        ));
    }

    /**
     * Send a POST request to the Paylike API.
     *
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    protected function post($uri, $data)
    {
        return $this->processResponse($this->client->post($this->buildUrl($uri), ['Content-Type' => 'application/json'], json_encode($data)));
    }

    /**
     * Send a PUT request to the Paylike API.
     *
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    protected function put($uri, $data)
    {
        return $this->processResponse($this->client->put($this->buildUrl($uri), ['Content-Type' => 'application/json'], json_encode($data)));
    }

    /**
     * Send a DELETE request to the Paylike API.
     *
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    protected function delete($uri, $data)
    {
        return $this->processResponse($this->client->delete($this->buildUrl($uri), ['Content-Type' => 'application/json'], json_encode($data)));
    }

    /**
     * Send a GET request to the Paylike API.
     *
     * @param string $uri
     *
     * @return array
     */
    protected function get($uri)
    {
        return $this->processResponse($this->client->get($this->buildUrl($uri)));
    }
}
