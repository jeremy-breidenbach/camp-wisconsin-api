<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\XmlArray;
use App\Libraries\XmlRequest;
use App\Campground;
use App\Campsite;

class SyncCampsites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:campsites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'STEP 3: Sync the camp-wisconsin database with data from the Active Campsite Search API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $campgrounds = Campground::all();
        $bar = $this->output->createProgressBar($campgrounds->count());
        foreach ($campgrounds as $campground)
        {
            $XmlRequest = new XmlRequest;
            $params = 'campsites/?contractCode=' . $campground->contractID . '&parkId=' . $campground->facilityID . '&api_key=' . env('CAMPGROUND_API_KEY');
            $response = $XmlRequest->getApiXml(env('CAMPGROUND_API_BASE_URI'), $params);

            $XmlArray = new XmlArray;
            $details = $XmlArray->xmlToArray($response);
            if ($details['resultset']['count'] === '1') {
                $campsite = $details['resultset']['result'];
                $this->saveCampsiteRecord($campground, $campsite);
            } else {
                $campsites = $details['resultset']['result'];
                foreach ($campsites as $campsite)
                {
                    $this->saveCampsiteRecord($campground, $campsite);
                }
            }
            $bar->advance();
        }
        $bar->finish();
    }

    public function saveCampsiteRecord($campground, $campsite)
    {
        $campsiteRecord = Campsite::firstOrNew(['siteID' => $campsite['SiteId']]);
        $campsiteRecord->campground_id = $campground->id;
        $campsiteRecord->loop = $campsite['Loop'];
        $campsiteRecord->maxEquipmentLength = $campsite['Maxeqplen'];
        $campsiteRecord->maxPeople = $campsite['Maxpeople'];
        $campsiteRecord->site = $campsite['Site'];
        $campsiteRecord->siteType = $campsite['SiteType'];
        $campsiteRecord->amps = $campsite['sitesWithAmps'];
        $campsiteRecord->petsAllowed = $campsite['sitesWithPetsAllowed'];
        $campsiteRecord->sewerHookup = $campsite['sitesWithSewerHookup'];
        $campsiteRecord->waterHookup = $campsite['sitesWithWaterHookup'];
        $campsiteRecord->waterfront = $campsite['sitesWithWaterfront'];
        $campsiteRecord->save();
    }
}
