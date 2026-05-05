<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function doctors()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
