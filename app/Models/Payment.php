<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sticker_id',
        'vehicle_id',
        'date',
        'amount',
        'receipt_number',

    ];

    protected $dates = [
        'deleted_at'
    ];

    public function sticker()
    {
        return $this->belongsTo(Sticker::class, 'sticker_id');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
