<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubWard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'ward_id',
        'description',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function streets()
    {
        return $this->hasMany(Street::class);
    }
    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}
