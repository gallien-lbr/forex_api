<?php

namespace App\Controller;

use App\Service\FreelanceUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class FreelanceToolsController extends AbstractController
{

    protected $utils;

    public function __construct(FreelanceUtils $utils)
    {
        $this->utils = $utils;
    }

    public function getIncome(Request $request)
    {
        try{
            $this->utils
                ->setAccre($request->query->get('accre'))
                ->setHasVAT($request->query->get('vat'))
                ->setPlf($request->query->get('plf'))
                ->setPrice($request->query->get('price'));

            $data = ['result' => $this->utils->getIncome()];
        }
        catch(\TypeError $e){
            $data =  ['error' => $e->getMessage() ];
            return $this->json($data, 400);
        }
        catch(Throwable $t){
            $data =  ['error' => $t->getMessage() ];
            return $this->json($data, 400);
        }

        return $this->json($data);
    }

    public function getSalesPrice(Request $request){

        try{
            $this->utils
                ->setAccre($request->query->get('accre'))
                ->setHasVAT($request->query->get('vat'))
                ->setPlf($request->query->get('plf'))
                ->setNetIncome($request->query->get('income'));

            $data = ['result' => $this->utils->getSalePrice()];
        }
        catch(\TypeError $e){
            $data =  ['error' => $e->getMessage() ];
            return $this->json($data, 400);
        }
        catch(Throwable $t){
            $data =  ['error' => $t->getMessage() ];
        }
        return $this->json($data);
    }
}
