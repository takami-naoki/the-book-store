<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];
    protected $dates = ['published_at'];

    public function path()
    {
        return '/books/' . $this->id;
    }
    
    public function setPublishedAtAttribute($published_at)
    {
        $this->attributes['published_at'] = Carbon::parse($published_at);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
