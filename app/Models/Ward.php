<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ward extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
    ];
    protected $dates = [
        'deleted_at',
    ];

    public function parkings()
    {
        return $this->hasMany(Parking::class);
    }
    public function streets()
    {
        return $this->hasMany(Street::class);
    }
}
