<?php


namespace App\Services;


use App\Interfaces\ApiRequestInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GuzzleHelperService
 * @package App\Services
 */
class GuzzleHelperService implements ApiRequestInterface
{
    private $client;

    /**
     * GuzzleHelperService constructor.
     * @param string $baseUrlRequest
     */
    public function __construct(
        string $baseUrlRequest
    )
    {

        $this->client = new Client(['base_uri' => $baseUrlRequest]);;
    }

    /**
     * @param string $url
     * @param string $method
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function sendApiRequest(string $url = '', string $method = 'GET')
    {
        return $this->client->request($method, $url);
    }
}