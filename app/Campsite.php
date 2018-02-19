<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campsite extends Model
{
    protected $guarded = ['id'];

    public function campground()
    {
         return $this->belongsTo('App\Campground');
    }
}
