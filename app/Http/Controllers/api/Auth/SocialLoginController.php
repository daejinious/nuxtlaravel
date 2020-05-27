<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Log;

class SocialLoginController extends Controller
{
    //
    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service)
    {
        Log::info("callback entrance");
        $serviceUser = Socialite::driver($service)->stateless()->user();
        dd($serviceUser);
    }
}
