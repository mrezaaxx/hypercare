<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'medical_record_number',
        'name',
        'nik',
        'birth_date',
        'gender',
        'address',
        'phone',
        'blood_type',
        'insurance_type',
        'insurance_number',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function labOrders(): HasMany
    {
        return $this->hasMany(LabOrder::class);
    }

    public function radiologyOrders(): HasMany
    {
        return $this->hasMany(RadiologyOrder::class);
    }

    public function igdVisits(): HasMany
    {
        return $this->hasMany(IgdVisit::class);
    }

    public function inpatientRegistrations(): HasMany
    {
        return $this->hasMany(InpatientRegistration::class);
    }
}
