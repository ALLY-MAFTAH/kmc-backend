<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parking_id',
        'location_name',
        'latitude',
        'longitude',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function parking()
    {
        return $this->belongsTo(Parking::class,'parking_id');
    }
}
