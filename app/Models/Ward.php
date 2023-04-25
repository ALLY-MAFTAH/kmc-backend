<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ward extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'name',
        'status',
        'province_id',
        'description',
    ];

    protected $dates=[
        'deleted_at'
    ];

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function subWards(){
        return $this->hasMany(SubWard::class);
    }

    public function businesses(){
        return $this->hasMany(Business::class);
    }
}
