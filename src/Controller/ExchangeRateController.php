<?php

namespace App\Controller;

use App\Service\ExchangeRateApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;

class ExchangeRateController extends AbstractController
{
    protected  $api;

    public function __construct(ExchangeRateApi $api)
    {
        $this->api = $api;
    }

    public function latest():JsonResponse{
        $response = $this->api->getClient()->request('GET', '/latest');
        return  JsonResponse::fromJsonString($response->getContent());
    }

}