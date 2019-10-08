<?php

namespace App\Controller;

use App\Service\ExchangeRateApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExchangeRateController extends AbstractController
{
    protected  $api;

    public function __construct(ExchangeRateApi $api)
    {
        $this->api = $api;
    }

    public function method(string $action):JsonResponse{
        if(!$action){
            throw new NotFoundHttpException('not found');
        }
        return  $this->api->getHttpContent($action);
    }



}