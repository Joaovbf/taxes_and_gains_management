<?php
/**
 * Created by PhpStorm.
 * User: jvito
 * Date: 29/04/2022
 * Time: 13:29
 */

namespace App\Service;


use App\Entity\Investment;
use App\Repository\InvestmentRepository;
use Doctrine\Persistence\ManagerRegistry;

class InvestmentService
{
    const GAIN_PERCENTAGE = 0.0052;
    const FIRST_YEAR_TAX = 0.225;
    const SECOND_YEAR_TAX = 0.185;
    const THIRD_YEAR_TAX = 0.15;

    public static function totalAmount(Investment $investment) {
        $withdraw = $investment->getWithdraw();
        $investment_finish_date =  !is_null($withdraw) ? $withdraw->getCreatedAt() : new \DateTime();

        $date_diff = $investment->getCreatedAt()->diff($investment_finish_date);
        $months = $date_diff->m + $date_diff->y*12;
        return $investment->getInitialAmount() * ((1 + self::GAIN_PERCENTAGE)**$months);
    }

    public static function calculateProfit(Investment $investment) {
        return self::totalAmount($investment) - $investment->getInitialAmount();
    }

    public static function getTaxation(Investment $investment) {
        $ageOfInvestment = $investment->getCreatedAt()->diff(new \DateTime())->y;
        if ($ageOfInvestment < 1){
            $tax = self::FIRST_YEAR_TAX;
        } else if ($ageOfInvestment > 2) {
            $tax = self::SECOND_YEAR_TAX;
        } else {
            $tax = self::THIRD_YEAR_TAX;
        }

        return self::calculateProfit($investment) * $tax;
    }

    /**
     * @param array $data
     *
     * @return Investment
     */
    public static function entityMassAssigned(array $data) {
        $investment = new Investment();

        //defining inicial date
        if (isset($data['created_at']))
            $created_at = new \DateTimeImmutable($data['created_at']);
        else
            $created_at = new \DateTimeImmutable();
;
        $investment->setInitialAmount($data['amount']);
        $investment->setCreatedAt($created_at);
        $investment->setUser($data['user']);

        return $investment;
    }
}