<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alert extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'msg',
        'date',
        'mobile',
        'category',
        'owner_id',
        'driver_id',
        'parking_id',
    ];
    protected $dates = [
        'deleted_at'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    public function parking()
    {
        return $this->belongsTo(Parking::class, 'parking_id');
    }
}
