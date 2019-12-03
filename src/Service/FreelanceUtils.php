<?php 
/** 
 * @author: Gallien
 * 
 *  Estimation revenu net en micro-entreprise (ancien Auto-Entrepreneur)
 *  WARNING: Ne tient pas compte du calcul de l'Impot sur le Revenu "au réel" (IR) 
 *  WARNING: Ne tient pas en compte les autres cotisations (ex: Cotisation Foncière Entreprise)
 */
declare(strict_types=1);
namespace App\Service;


class FreelanceUtils
{
    const PLF = 0.022;
    const MICRO_SOCIAL_CFP = 0.01;
    const VAT = 0.20;
    
    // revenu net
    protected $netIncome;

    // prix de vente
    protected $price;
    
    // prelevement  liberatoire forfaitaire
    protected $plf = false;

    // soumis à la TVA ou non
    protected $hasVAT = false;

    public function setHasVAT(bool $pHasVAT):self
    {
        $this->hasVAT = (bool)$pHasVAT;
        return $this;
    }

    public function setAccre(float $pAccre):self
    {
        $this->accre = $pAccre;
        return $this;
    }

    public function setPlf(bool $pPlf):self
    {
        $this->plf = $pPlf;
        return $this;
    }

    public function setNetIncome(float $pNetIncome = null):self
    {
        $this->netIncome = $pNetIncome;
        return $this;
    }

    public function getNetIncome():int
    {
        return $this->netIncome;
    }

    public function setPrice(float $price):self
    {
        $this->price = $price;
        return $this;
    }

    public function getPrice():float
    {
        return $this->price;
    }

    public function getIncome():float
    {
        if(! $this->price) {
            throw new \Exception('Price not set. Can not proceed.');
        }
        return round($this->getCosts()  * $this->price);
    }

    public function getSalePrice():int
    {
        if(! $this->netIncome) {
            throw new \Exception('Net income not set. Can not proceed.');
        }
        return  (int)round($this->netIncome / $this->getCosts());
    }

    /**
     * Calcul des coûts liés à l'activité (cotisations)
     */
    public function getCosts():float
    {
        $costs = 1;  
        $costs -=  $this->plf ?  self::PLF : 0;
        $costs -=  $this->hasVAT ? self::VAT : 0;
        $costs -=  $this->accre + self::MICRO_SOCIAL_CFP;
        return $costs;
    }
}
