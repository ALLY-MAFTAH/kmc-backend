<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nida',
        'mobile',
        'first_name',
        'middle_name',
        'last_name',
        'photo',
    ];

    protected $dates=[
        'deleted_at'
    ];

    public function vehicle()
    {
        return  $this->hasOne(Vehicle::class);
    }
    public function alerts()
    {
        return  $this->hasMany(Alert::class);
    }
}
