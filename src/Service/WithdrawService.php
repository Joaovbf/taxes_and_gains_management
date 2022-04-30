<?php
/**
 * Created by PhpStorm.
 * User: jvito
 * Date: 29/04/2022
 * Time: 20:12
 */

namespace App\Service;


use App\Entity\Withdraw;

class WithdrawService
{
    public static function entityMassAssigned(array $data) {
        $withdraw = new Withdraw();
        $withdraw->setAmount($data["amount"]);
        $withdraw->setGrossAmount($data["gross_amount"]);
        $withdraw->setCreatedAt($data["created_at"]);
        $withdraw->setInvestment($data['investment']);
        $withdraw->setTaxes($data['taxes']);

        return $withdraw;
    }
}