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
        'category',
        'sticker_id',
        'vehicle_id',
    ];
    protected $dates = [
        'deleted_at'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function sticker()
    {
        return $this->belongsTo(Sticker::class);
    }}
