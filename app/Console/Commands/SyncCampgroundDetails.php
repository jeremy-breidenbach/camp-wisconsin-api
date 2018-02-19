<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\XmlFunctions;
use App\Campground;

class SyncCampgroundDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:campgrounddetails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'STEP 2: Sync the camp-wisconsin database with data from the Active Campground Details API';

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
            $XmlFunctions = new XmlFunctions;
            $requestDetails = 'campground/details?contractCode=' . $campground->contractID . '&parkId=' . $campground->facilityID . '&api_key=' . env('CAMPGROUND_API_KEY');
            $xml = $XmlFunctions->getApiXml(env('CAMPGROUND_API_BASE_URI'), $requestDetails);
            $details = $XmlFunctions->xmlToArray($xml);
            $campground->description = html_entity_decode(html_entity_decode($details['detailDescription']['description']), ENT_QUOTES | ENT_HTML401);
            $campground->address = $details['detailDescription']['address']['streetAddress'];
            $campground->city = $details['detailDescription']['address']['city'];
            $campground->state = $details['detailDescription']['address']['state'];
            $campground->zip = $details['detailDescription']['address']['zip'];
            $campground->drivingDirection = $details['detailDescription']['drivingDirection'];
            $campground->reservationUrl = $details['detailDescription']['fullReservationUrl'];
            $campground->photos = json_encode($details['detailDescription']['photo']);
            $campground->amenities = json_encode($details['detailDescription']['amenity']);
            $campground->save();
            $bar->advance();
        }
        $bar->finish();
    }
}
