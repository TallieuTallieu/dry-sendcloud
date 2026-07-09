<?php

namespace Tnt\Sendcloud;

use Tnt\Sendcloud\Client\SendcloudClient;

class Api
{
    /**
     * @var SendcloudClient
     */
    private $client;

    /**
     * Api constructor.
     * @param SendcloudClient $client
     */
    public function __construct(SendcloudClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return array<int|string, mixed>
     * @throws Exception\SendcloudException
     */
    public function getParcels(): array
    {
        $response = $this->client->get('parcels');
        return $response['parcels'];
    }

    /**
     * @param int $id
     * @return array<string, mixed>
     * @throws Exception\SendcloudException
     */
    public function getParcel(int $id): array
    {
        $response = $this->client->get('parcels/' . $id);
        return $response['parcel'];
    }

    /**
     * @param array<string, mixed> $parcel
     * @return array<string, mixed>
     * @throws Exception\SendcloudException
     */
    public function createParcel(array $parcel): array
    {
        $response = $this->client->post('parcels', $parcel);
        return $response['parcel'];
    }

    /**
     * @param int $id
     * @return array<string, mixed>
     * @throws Exception\SendcloudException
     */
    public function cancelParcel(int $id): array
    {
        return $this->client->post('parcels/' . $id . '/cancel');
    }

    /**
     * @return array<int, array<string, mixed>>
     * @throws Exception\SendcloudException
     */
    public function getShippingMethods(): array
    {
        $response = $this->client->get('shipping_methods');
        return $response['shipping_methods'];
    }
}
