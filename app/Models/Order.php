<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function village()
    {
        return $this->belongsTo('App\Models\Village');
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\Owner');
    }

    public function orderCategories()
    {
        return $this->hasMany('App\Models\OrderCategory');
    }

    public function htetYus()
    {
        return $this->hasMany('App\Models\HtetYu');
    }

    public function payInterests()
    {
        return $this->hasMany('App\Models\Interest');
    }

    public function eduction()
    {
        return $this->belongsTo('App\Models\Eduction');
    }
}
