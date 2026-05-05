<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InpatientRegistration extends Model
{
    protected $fillable = [
        'registration_number',
        'patient_id',
        'igd_visit_id',
        'admission_date',
        'admission_source',
        'ward',
        'room_number',
        'bed_number',
        'room_class',
        'doctor_in_charge',
        'admission_diagnosis',
        'final_diagnosis',
        'treatment_notes',
        'discharge_date',
        'discharge_type',
        'status',
        'admitted_by',
    ];

    protected function casts(): array
    {
        return [
            'admission_date' => 'datetime',
            'discharge_date' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function igdVisit(): BelongsTo
    {
        return $this->belongsTo(IgdVisit::class, 'igd_visit_id');
    }

    public function admittedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admitted_by');
    }

    public function getLengthOfStayAttribute(): ?int
    {
        if (!$this->admission_date) return null;
        $end = $this->discharge_date ?? now();
        return (int) $this->admission_date->diffInDays($end);
    }
}
