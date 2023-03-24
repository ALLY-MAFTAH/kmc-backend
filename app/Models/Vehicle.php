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
    public function parking()
    {
        return  $this->belongsTo(Parking::class, 'parking_id');
    }
    public function stickers()
    {
        return  $this->hasMany(Sticker::class);
    }
}
