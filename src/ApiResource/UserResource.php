<?php
/**
 * Created by PhpStorm.
 * User: jvito
 * Date: 29/04/2022
 * Time: 11:39
 */

namespace App\ApiResource;


class UserResource extends Resource
{
    public function make($user) {
        return [
            "id" => $user->getId(),
            "name" => $user->getName()
        ];
    }
}