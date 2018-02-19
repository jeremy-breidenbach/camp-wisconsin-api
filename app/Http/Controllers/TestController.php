<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\XmlFunctions;

class TestController extends Controller
{
    public function testCampsitesArray($contractCode, $parkId)
    {
        $XmlFunctions = new XmlFunctions;
        $requestDetails = 'campsites/?contractCode=' . $contractCode . '&parkId=' . $parkId . '&api_key=' . env('CAMPGROUND_API_KEY');
        $xml = $XmlFunctions->getApiXml(env('CAMPGROUND_API_BASE_URI'), $requestDetails);
        $details = $XmlFunctions->xmlToArray($xml);
        $campsites = $details['resultset']['result'];
        dd($campsites);
    }
}
