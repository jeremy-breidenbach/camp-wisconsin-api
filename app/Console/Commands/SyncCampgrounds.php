<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\XmlFunctions;
use App\Campground;

class SyncCampgrounds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:campgrounds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'STEP 1: Sync the camp-wisconsin database with data from the Active Campground Search API';

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
        $XmlFunctions = new XmlFunctions;
        $xml = $XmlFunctions->getApiXml(env('CAMPGROUND_API_BASE_URI'), 'campgrounds?pstate=WI&api_key=' . env('CAMPGROUND_API_KEY'));
        $results = $XmlFunctions->xmlToArray($xml);
        $campgrounds = $results['resultset']['result'];
        $bar = $this->output->createProgressBar(count($campgrounds));

        foreach ($campgrounds as $campground) {
            if (($campground['contractID'] != 'ELSI') && ($campground['contractID'] != 'INDP')) {
                $campgroundRecord = Campground::firstOrNew(['facilityID' => $campground['facilityID']]);
                $campgroundRecord->facilityName = $campground['facilityName'];
                $campgroundRecord->contractID = $campground['contractID'];
                $campgroundRecord->facilityPhoto = $campground['faciltyPhoto'];
                $campgroundRecord->latitude = $campground['latitude'];
                $campgroundRecord->longitude = $campground['longitude'];
                $campgroundRecord->sitesWithAmps = $campground['sitesWithAmps'];
                $campgroundRecord->sitesWithPetsAllowed = $campground['sitesWithPetsAllowed'];
                $campgroundRecord->sitesWithSewerHookup = $campground['sitesWithSewerHookup'];
                $campgroundRecord->sitesWithWaterHookup = $campground['sitesWithWaterHookup'];
                $campgroundRecord->sitesWithWaterfront = $campground['sitesWithWaterfront'];
                $campgroundRecord->save();
            }
            $bar->advance();
        }

        $bar->finish();
    }
}
