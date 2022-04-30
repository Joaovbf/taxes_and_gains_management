<?php
/**
 * Created by PhpStorm.
 * User: jvito
 * Date: 30/04/2022
 * Time: 13:45
 */

namespace App\Validator;


class InvesmentCreateValidator
{
    public static function validate($data) {
        if ($data["amount"] < 0){
            throw new \Exception("The amount could not be negative");
        }
        if (isset($data["created_at"]) && (new \DateTime($data["created_at"]))->diff(new \DateTime())->invert) {
            throw new \Exception("The creation date must be today or in the past");
        }
    }
}