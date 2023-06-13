<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Street extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'name',
        'status',
        'sub_ward_id',
        'description',
    ];

    protected $dates=[
        'deleted_at'
    ];

    public function subWard(){
        return $this->belongsTo(SubWard::class,'sub_ward_id');
    }

    public function parkings(){
        return $this->hasMany(Parking::class);
    }
}
