<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campground extends Model
{
    protected $guarded = ['id'];

    public function campsites()
    {
        return $this->hasMany('App\Campsite');
    }
}
