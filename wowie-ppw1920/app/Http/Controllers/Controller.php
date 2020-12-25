<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    protected function getToken(Request $request) : ?string
    {
        $token = $request->header('Authorization', '');
        if (!Str::startsWith($token, 'AuthToken-')) {
            return null;
        }

        return(Str::substr($token, 10));
    }
    
}
