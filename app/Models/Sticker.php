<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sticker extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'number',
        'start_date',
        'end_date',
        'period',
        'is_valid',
        'vehicle_id',
    ];

    protected $dates = [
        'deleted_at',
    ];
    public function vehicle()
    {
        return  $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    public function payment()
    {
        return  $this->hasOne(Payment::class);
    }
}
