<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Owner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nida',
        'mobile',
        'first_name',
        'middle_name',
        'last_name',
    ];

    protected $dates=[
        'deleted_at'
    ];

    public function vehicles()
    {
        return  $this->hasMany(Vehicle::class);
    }
}
