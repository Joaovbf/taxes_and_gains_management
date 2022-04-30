<?php
/**
 * Created by PhpStorm.
 * User: jvito
 * Date: 29/04/2022
 * Time: 12:10
 */

namespace App\ApiResource;


use App\Entity\Investment;
use App\Service\InvestmentService;
use Doctrine\ORM\Mapping\Entity;

class InvestmentResource extends Resource
{
    /**
     * @param Investment $investment
     * @return array
     */
    public function make($investment) {
        return [
            "id" => $investment->getId(),
            "amount" => number_format(InvestmentService::totalAmount($investment),2,",", "."),
            "profit" => number_format(InvestmentService::calculateProfit($investment),2,",", "."),
        ];
    }
}