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
        'street_id',
        'leader_name',
        'leader_mobile',
        'leader_photo',
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
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id');
    }
}
