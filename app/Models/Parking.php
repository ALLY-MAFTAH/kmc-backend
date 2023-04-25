<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pln',
        'name',
        'province_id',
        'ward_id',
        'sub_ward_id',
        'street_id',
        'leader_name',
        'leader_mobile',
        'capacity',
        'no_of_vehicles',
        'status',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function location()
    {
        return $this->hasOne(Location::class);
    }
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }
    public function subWard()
    {
        return $this->belongsTo(SubWard::class, 'sub_ward_id');
    }
    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id');
    }
}
