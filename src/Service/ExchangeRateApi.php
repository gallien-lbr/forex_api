<?php


namespace App\Service;

use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;

class ExchangeRateApi
{
    protected $api;
    protected $client;

    public function __construct(string $XRApi, string $cacheDir){

        $store = new Store($cacheDir);
        $this->api =  $XRApi;
        $this->client =  HttpClient::create();

        // @see : https://symfony.com/doc/current/components/http_client.html
        $this->client = new CachingHttpClient(
            $this->client, $store,
            ['base_uri'=> 'https://'.$this->api]
        );
    }

    public function getClient(){
        return $this->client;
    }

}