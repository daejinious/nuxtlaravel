<?php

namespace App\SocialiteProviders\Kakao;

use SocialiteProviders\Kakao\KakaoProvider as BaseKakaoProvider;

class KakaoProvider extends BaseKakaoProvider
{
    protected function getTokenFields($code): array
    {
        return [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUrl,
            'code' => $code,
        ];
    }
}
