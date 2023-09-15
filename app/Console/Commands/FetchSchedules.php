<?php

namespace App\Console\Commands;

use App\Libraries\Provider\ProviderFactory;
use App\Libraries\Utilities\Encryption;
use App\Models\Credentials;
use App\Models\Scheduler;
use Google\Service\Drive;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FetchSchedules extends Command
{
    protected $drive;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $providerObject;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Drive $drive)
    {
        parent::__construct();
        $this->drive = $drive;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files = $this->drive->files->listFiles()->getFiles();
        $name = '' . 'video-' . time() . '.mp4';
        $targetFilePath = base_path() . "/public/" . $name;

        if (isset($files) && is_array($files)) {
            $getFileId = $files[1]['id'];
            header('Content-Type: video/mp4');
            $response = $this->drive->files->get($getFileId, array(
                'alt' => 'media'));
            $content = $response->getBody()->getContents();
            $storageResponse = Storage::disk('local')->put($targetFilePath, $content);
            if ($storageResponse) {

                $getSchedules = Scheduler::get();
                foreach ($getSchedules as $value) {

                    $credentials = $this->getCredentials($value->social_type);
                    $this->providerObject = (new ProviderFactory($value->social_type, $credentials))->getProvider();

                }

                $this->info('file => ' . $targetFilePath);
            } else {
                $this->error('Not able to store file Please try again!');
            }
        }
        return 0;
    }

    /**
     * @param $socialType
     * @return array|mixed
     */
    private function getCredentials($socialType)
    {
        $credential = Credentials::where([
            Credentials::TYPE => $socialType,
            Credentials::PRIORITY => 1,
            Credentials::STATUS => 1
        ])
            ->orderBy('created_at', 'desc')
            ->first();

        $apiDetail = [];
        if (!empty($credential)) {

            $apiDetail = json_decode($credential, 1);
            foreach ($apiDetail as $key => $val) {
                $passKey = hash('sha256', $socialType);
                $apiDetail[$key] = (new Encryption($passKey))->decrypt($val);
            }
        }
        return $apiDetail;
    }
}
