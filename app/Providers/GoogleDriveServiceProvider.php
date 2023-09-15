<?php

namespace App\Providers;

use Google\Client as GoogleClient;
use Google\Service\Drive;
use Illuminate\Support\ServiceProvider;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Drive::class, function ($app) {
            $client = new GoogleClient();
            $client->setAuthConfig(public_path('./drive-391618-d8501f6fffcd.json'));
            $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_DRIVE_PRIVATE_KEY'));
            $client->setScopes([
                \Google_Service_Drive::DRIVE,
                \Google_Service_Drive::DRIVE_FILE,
                \Google_Service_Drive::DRIVE_METADATA,
                \Google_Service_Drive::DRIVE_READONLY,
            ]);

            $client->useApplicationDefaultCredentials();
            return new Drive($client);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        \Storage::extend("google", function($app, $config) {
//            $client = new \Google_Client;
//            $client->setClientId($config['clientId']);
//            $client->setClientSecret($config['clientSecret']);
//            $client->refreshToken($config['refreshToken']);
//            $service = new \Google_Service_Drive($client);
//            $adapter = new GoogleDriveAdapter($service, $config['folderId']);
//            return new Filesystem($adapter);
//        });
    }
}
