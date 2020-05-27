<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSocial;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Log;
use Tymon\JWTAuth\JWTAuth;

class SocialLoginController extends Controller
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->middleware('social');
        $this->auth = $auth;
    }

    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service)
    {
        Log::info("callback entrance");
        try {
            $serviceUser = Socialite::driver($service)->stateless()->user();
        } catch (InvalidStateException $e) {
            return redirect(env('CLIENT_BASE_URL') . '?error=Unable to login using ' . $service . ' Please try again.');
        }

        $email = $serviceUser->getEmail();
        if ($service !== 'google') {
            $email = $serviceUser->getId() . '@' . $service . '.local';
        }

        $user = $this->getExistingUser($serviceUser, $email, $service);
        if (!$user) {
            $user = User::create([
                'name' => $serviceUser->getName(),
                'email' => $email,
                'password' => ''
            ]);
        }

        if ($this->needsToCreateSocial($user, $service)) {
            UserSocial::create([
                'user_id' => $user->id,
                'social_id' => $serviceUser->getId(),
                'service' => $service
            ]);
        }

        dd($user);
    }

    public function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }

    public function getExistingUser($serviceUser, $email, $service)
    {
        if ($service === 'google') {
            return User::where('email', $email)->orWhereHas('social', function ($q) use ($serviceUser, $service) {
                $q->where('social_id', $serviceUser->getId())->where('service', $service);
            })->first();
        }
        $userSocial = UserSocial::where('social_id', $serviceUser->getId())->first();
        return $userSocial ? $userSocial->user : null;
    }
}
