<?php


namespace App\Services;


use App\Interfaces\ApiRequestInterface;

/**
 * Class ApiRequestService
 * @package App\Services
 */
class ApiRequestService
{

    private $apiRequest;
    const BASE_URL_REQUEST = 'https://www.bestjobs.eu/';

    /**
     * @return mixed
     */
    public function getUrlData($url = "ro/locuri-de-munca?location=bucuresti&keyword=symfony")
    {
        return $this->apiRequest->sendApiRequest($url);
    }

    /**
     * @param ApiRequestInterface $apiRequest
     */
    public function setApiRequestHelper(ApiRequestInterface $apiRequest)
    {
        $this->apiRequest = $apiRequest;
    }

}