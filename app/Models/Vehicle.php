<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'reg_number',
        'owner_id',
        'driver_id',
        'parking_id',
        'type',
        'brand',
        'period',
        'color',
        'status',
    ];

    protected $dates = [
        'deleted_at',
    ];
    public function owner()
    {
        return  $this->belongsTo(Owner::class, 'owner_id');
    }
    public function driver()
    {
        return  $this->belongsTo(Driver::class, 'driver_id');
    }
    public function parking()
    {
        return  $this->belongsTo(Parking::class, 'parking_id');
    }
    public function stickers()
    {
        return  $this->hasMany(Sticker::class);
    }
    public function payments()
    {
        return  $this->hasMany(Payment::class);
    }
    public function alerts()
    {
        return  $this->hasMany(Alert::class);
    }
}
