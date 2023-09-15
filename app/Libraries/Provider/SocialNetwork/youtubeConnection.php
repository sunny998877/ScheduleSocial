<?php

namespace App\Libraries\Provider\SocialNetwork;

use App\Libraries\SocialNetwork\Http;
use Illuminate\Http\Request;

class youtubeConnection
{
    private $accessToken;
    private $clientId;
    private $redirectUri;
    private $clientSecret;
    private $baseUrl;

    /**
     * @param $creds
     */
    public function __construct($creds)
    {
        $this->clientId = $creds['client_id'] ?? '';
        $this->clientSecret = $creds['client_secret'] ?? '';
        $this->redirectUri = $creds['redirect_url'] ?? '';
        $this->baseUrl = $creds['base_url'] ?? '';
    }

    /**
     * @param $files
     * @return \Google\Service\YouTube\Video
     */
    public function uploadShortVideo($files)
    {
        $client = new \Google_Client();
//        $client->setApplicationName('API code samples');
        $client->setScopes([
            'https://www.googleapis.com/auth/youtube.upload',
        ]);

        $client->setClientId($this->clientId);
        $client->setClientSecret($this->clientSecret);
        $client->setAccessType('offline');

        $client->setAccessToken($this->accessToken);
        $service = new \Google_Service_YouTube($client);
        $video = new \Google_Service_YouTube_Video();

        $videoSnippet = new \Google_Service_YouTube_VideoSnippet();
        $videoSnippet->setCategoryId('22');
        $videoSnippet->setDescription('Description of uploaded video.');
        $videoSnippet->setTitle('Test video upload.');
        $video->setSnippet($videoSnippet);

        $videoStatus = new \Google_Service_YouTube_VideoStatus();
        $videoStatus->setPrivacyStatus('private');
        $video->setStatus($videoStatus);

        $response = $service->videos->insert(
            'snippet,status',
            $video,
            array(
                'data' => file_get_contents($files),
                'mimeType' => 'video/*',
                'uploadType' => 'multipart'
            )
        );

        return $response;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAuthorizationCode()
    {
        $scopes = [
            'https://www.googleapis.com/auth/youtube', // Required scope for YouTube API access
            'https://www.googleapis.com/auth/youtube.upload',
        ];

        $authorizationUrl = 'https://accounts.google.com/o/oauth2/auth' . '?' . http_build_query([
                'client_id' => $this->clientId,
                'redirect_uri' => $this->redirectUri,
                'scope' => implode(' ', $scopes),
                'response_type' => 'code',
            ]);

        return redirect()->away($authorizationUrl);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getAccessToken(Request $request)
    {
        $code = $request->input('code');

        $accessTokenUrl = 'https://accounts.google.com/o/oauth2/token';

        $response = Http::post($accessTokenUrl, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);

        $this->accessToken = $response->json()['access_token'];

        return $this->accessToken;
    }
}
