<?php

namespace Tnt\Sendcloud\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ResponseException;
use GuzzleHttp\Exception\TransferException;
use Psr\Http\Message\ResponseInterface;
use Tnt\Sendcloud\Exception\SendcloudException;

class SendcloudClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * SendcloudClient constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param $endPoint
     * @param array<string, mixed> $params
     * @return array<string, mixed>
     * @throws SendcloudException
     */
    public function get(string $endPoint, array $params = []): array
    {
        try {
            return $this->parseResponse(
                $this->client->request('GET', $endPoint, ['query' => $params])
            );
        } catch (TransferException $e) {
            if ($e instanceof ResponseException) {
                $this->parseResponse($e->getResponse());
            }

            throw $this->requestException('GET', $e);
        }
    }

    /**
     * @param string $endPoint
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     * @throws SendcloudException
     */
    public function post(string $endPoint, array $body = []): array
    {
        try {
            $response = $this->client->request('POST', $endPoint, [
                'body' => json_encode($body),
            ]);

            return $this->parseResponse($response);
        } catch (TransferException $e) {
            if ($e instanceof ResponseException) {
                $this->parseResponse($e->getResponse());
            }

            throw $this->requestException('POST', $e);
        }
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     * @throws SendcloudException
     */
    public function put(string $endPoint, array $body): array
    {
        try {
            $response = $this->client->request('PUT', $endPoint, [
                'body' => json_encode($body),
            ]);

            return $this->parseResponse($response);
        } catch (ClientException $e) {
            throw new SendcloudException(
                'Sendcloud error (ClientException)' .
                    $e->getResponse()->getBody()->getContents(),
                $e->getResponse()->getStatusCode()
            );
        } catch (TransferException $e) {
            if ($e instanceof ResponseException) {
                $this->parseResponse($e->getResponse());
            }

            throw $this->requestException('PUT', $e);
        }
    }

    /**
     * @param $endPoint
     * @return array<string, mixed>
     * @throws SendcloudException
     */
    public function delete(string $endPoint): array
    {
        try {
            return $this->parseResponse(
                $this->client->request('DELETE', $endPoint)
            );
        } catch (TransferException $e) {
            if ($e instanceof ResponseException) {
                $this->parseResponse($e->getResponse());
            }

            throw $this->requestException('DELETE', $e);
        }
    }

    /**
     * @param string $url
     * @return string
     * @throws SendcloudException
     */
    public function download(string $url): string
    {
        try {
            $result = $this->client->request('GET', $url);
            return $result->getBody()->getContents();
        } catch (TransferException $e) {
            throw $this->requestException('DOWNLOAD', $e);
        }
    }

    /**
     * @param ResponseInterface $response
     * @return array<string, mixed>
     * @throws SendcloudException
     */
    private function parseResponse(ResponseInterface $response): array
    {
        try {
            $responseBody = $response->getBody()->getContents();
            $resultArray = json_decode($responseBody, true);

            if (!is_array($resultArray)) {
                throw new SendcloudException(
                    sprintf(
                        'SendCloud error %s: %s',
                        $response->getStatusCode(),
                        $responseBody
                    ),
                    $response->getStatusCode()
                );
            }

            if (
                array_key_exists('error', $resultArray) &&
                is_array($resultArray['error']) &&
                array_key_exists('message', $resultArray['error'])
            ) {
                throw new SendcloudException(
                    'SendCloud error: ' . $resultArray['error']['message'],
                    $resultArray['error']['code']
                );
            }

            return $resultArray;
        } catch (\RuntimeException $e) {
            throw new SendcloudException('Sendcloud error ' . $e->getMessage());
        }
    }

    private function requestException(
        string $method,
        TransferException $exception
    ): SendcloudException {
        if (!($exception instanceof ResponseException)) {
            return new SendcloudException(
                sprintf(
                    'Sendcloud error (method: %s): %s',
                    $method,
                    $exception->getMessage()
                ),
                $exception->getCode()
            );
        }

        $response = $exception->getResponse();

        return new SendcloudException(
            sprintf(
                'Sendcloud error (method: %s): %s',
                $method,
                $response->getBody()->getContents()
            ),
            $response->getStatusCode()
        );
    }
}
