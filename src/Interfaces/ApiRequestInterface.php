<?php

namespace App\Interfaces;

/**
 * Interface ApiRequestInterface
 * @package App\Interfaces
 */
interface ApiRequestInterface
{
    public function sendApiRequest(string $url, string $method);
}