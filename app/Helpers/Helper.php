<?php

namespace App\Helpers;
use Illuminate\Support\Str;
class Helper
{

    public static function roleName($roleId) {
        $result = "";
        if($roleId == 1) {
            $result = "Superadmin";
        }
        else if($roleId == 2) { 
            $result = "User";
        } 
        return $result;
    }
}