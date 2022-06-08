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
}
