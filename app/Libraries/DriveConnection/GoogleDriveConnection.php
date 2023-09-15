<?php

namespace App\Libraries\DriveConnection;

use Google\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Google_Client;
use Google_Service_Drive;

class GoogleDriveConnection
{
    private $clientId = '562666513106-3qlkq52o7mrid38jqav5knmi0tlrbsbg.apps.googleusercontent.com';
    private $clientSecret = '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';
    private $redirectUri = 'http://localhost:8000';

    public function getAuthorizationCode()
    {
        $scopes = [
            'https://www.googleapis.com/auth/drive',
            'https://www.googleapis.com/auth/drive',
            'https://www.googleapis.com/auth/drive.appdata',
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive.metadata'
        ];
        $authorizationUrl = $this->createGoogleClient()
            ->createAuthUrl($scopes);
dump($authorizationUrl);

        $response = (new GuzzleClient())->get($authorizationUrl);
//
//        $responseBody = (string) $response->getBody();
//        dump($responseBody);
        // Extract the authorization code from the response URL
        $authCode = $this->extractAuthorizationCode($response->getHeaderLine('Location'));
        dd($authCode);
        return redirect()->away($authorizationUrl);
    }

    public function getAccessToken(Request $request)
    {
        $code = $request->input('code');
        $accessToken = $this->createGoogleClient()
            ->fetchAccessTokenWithAuthCode($code);

        $accessToken = $accessToken['access_token'];

        return $accessToken;
    }

    private function createGoogleClient()
    {
        $client = new Google_Client();
        $client->setClientId($this->clientId);
        $client->setClientSecret($this->clientSecret);
        $client->setRedirectUri($this->redirectUri);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->setPrompt('consent');


        return $client;
    }

    public function getDriveFiles($accessToken)
    {
        $client = $this->createGoogleClient($this->clientId, $this->clientSecret);
        $client->setAccessToken($accessToken);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $accessToken = $client->getAccessToken()['access_token'];
        }

        $service = new Google_Service_Drive($client);
        $files = $service->files->listFiles();

        return $files;
    }

    private function extractAuthorizationCode($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $queryParameters);
        return $queryParameters['code'] ?? null;
    }
}
