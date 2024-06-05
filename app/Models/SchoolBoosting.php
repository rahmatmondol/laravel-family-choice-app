<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBoosting extends Model
{
    use HasFactory;

    public function citys()
    {
        return $this->belongsTo(City::class,'city_id');
    }
}
