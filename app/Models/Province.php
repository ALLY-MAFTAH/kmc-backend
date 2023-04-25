<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'description',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
    public function parkings()
    {
        return $this->hasMany(Parking::class);
    }
}
