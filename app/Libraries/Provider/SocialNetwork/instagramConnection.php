<?php

namespace App\Libraries\Provider\SocialNetwork;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class instagramConnection
{
    public function getAuthorizationCode()
    {
        $clientId = 'YOUR_CLIENT_ID';
        $redirectUri = 'YOUR_REDIRECT_URI';
        $scopes = 'user_profile,user_media'; // Customize scopes as per your requirements

        $authorizationUrl = 'https://api.instagram.com/oauth/authorize' . '?' . http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'scope' => $scopes,
                'response_type' => 'code',
            ]);

        return redirect()->away($authorizationUrl);
    }

    public function getAccessToken(Request $request)
    {
        $clientId = 'YOUR_CLIENT_ID';
        $clientSecret = 'YOUR_CLIENT_SECRET';
        $redirectUri = 'YOUR_REDIRECT_URI';
        $code = $request->input('code');

        $accessTokenUrl = 'https://api.instagram.com/oauth/access_token';

        $response = Http::post($accessTokenUrl, [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri,
            'code' => $code,
        ]);

        $accessToken = $response->json()['access_token'];

        return $accessToken;
    }
}
