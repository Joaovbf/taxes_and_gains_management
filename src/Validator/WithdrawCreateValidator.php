<?php
/**
 * Created by PhpStorm.
 * User: jvito
 * Date: 30/04/2022
 * Time: 13:20
 */

namespace App\Validator;


use App\Entity\Investment;
use App\Repository\InvestmentRepository;
use App\Repository\WithdrawRepository;
use Doctrine\Persistence\ManagerRegistry;

class WithdrawCreateValidator
{
    public static function validate(Investment $investment, $data) {
        if ($investment->getWithdraw() != null){
            throw new \Exception("This investment has already withdrawn");
        }
        if ($investment->getCreatedAt()->diff(new \DateTime($data["created_at"] ?? null))->invert) {
            throw new \Exception("The creation date of withdraw must be after the investment creation");
        }
        if (isset($data["created_at"]) && (new \DateTime($data["created_at"]))->diff(new \DateTime())->invert){
            throw new \Exception("The creation date must be today or in the past");
        }
    }
}