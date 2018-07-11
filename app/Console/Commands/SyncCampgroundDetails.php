<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\XmlArray;
use App\Libraries\XmlRequest;
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
            $XmlRequest = new XmlRequest;
            $params = 'campground/details?contractCode=' . $campground->contractID . '&parkId=' . $campground->facilityID . '&api_key=' . env('CAMPGROUND_API_KEY');
            $response = $XmlRequest->getApiXml(env('CAMPGROUND_API_BASE_URI'), $params);

            $XmlArray = new XmlArray;
            $detailsArray = $XmlArray->xmlToArray($response);
            $details = $detailsArray['detailDescription'];
            $campground->description = html_entity_decode(html_entity_decode($details['description']), ENT_QUOTES | ENT_HTML401);
            $campground->address = $details['address']['streetAddress'];
            $campground->city = $details['address']['city'];
            $campground->state = $details['address']['state'];
            $campground->zip = $details['address']['zip'];
            $campground->drivingDirection = $details['drivingDirection'];
            $campground->reservationUrl = $details['fullReservationUrl'];
            $campground->photos = json_encode($details['photo']);
            $campground->amenities = json_encode($details['amenity']);
            $campground->save();
            $bar->advance();
        }
        $bar->finish();
    }
}
