<?php

namespace App\Http\Controllers;

use App\Campsite;
use Illuminate\Http\Request;

class CampsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($campgroundId)
    {
        $campsites = Campsite::where('campground_id', $campgroundId)
            ->orderBy('site', 'asc')
            ->get();
        return $campsites;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campsite  $campsite
     * @return \Illuminate\Http\Response
     */
    public function show($campgroundId, Campsite $campsite)
    {
        return $campsite;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campsite  $campsite
     * @return \Illuminate\Http\Response
     */
    public function edit(Campsite $campsite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campsite  $campsite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campsite $campsite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campsite  $campsite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campsite $campsite)
    {
        //
    }
}
