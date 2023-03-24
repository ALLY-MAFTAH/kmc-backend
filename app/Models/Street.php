<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Street extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'ward_id',
        'status',
    ];
    protected $dates = [
        'deleted_at',
    ];

    public function parkings()
    {
        return $this->hasMany(Parking::class);
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class,'ward_id');
    }
}
