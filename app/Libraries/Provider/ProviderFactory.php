<?php

namespace App\Libraries\Provider;

use App\Libraries\Provider\SocialNetwork\instagramConnection;
use App\Libraries\Provider\SocialNetwork\youtubeConnection;
use App\Libraries\Utilities\Constants;

class ProviderFactory
{
    private $IProvider;
    private $apiDetail;

    const ProviderClassMapping = [
        Constants::YOUTUBE          => youtubeConnection::class,
        Constants::INSTAGRAM        => instagramConnection::class,
    ];

    public function __construct($provider, $detail)
    {
        $this->details = $detail;
        $this->IProvider = self::ProviderClassMapping[strtoupper($provider)];
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return new $this->IProvider($this->details);
    }
}
