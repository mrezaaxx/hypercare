<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IgdVisit extends Model
{
    protected $fillable = [
        'visit_number',
        'patient_id',
        'arrival_time',
        'arrival_method',
        'triage_category',
        'systolic_bp',
        'diastolic_bp',
        'pulse_rate',
        'respiratory_rate',
        'temperature',
        'oxygen_saturation',
        'gcs_score',
        'chief_complaint',
        'physical_exam',
        'diagnosis',
        'action_taken',
        'status',
        'handled_by',
    ];

    protected function casts(): array
    {
        return [
            'arrival_time' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function handledByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function inpatientRegistration(): HasOne
    {
        return $this->hasOne(InpatientRegistration::class, 'igd_visit_id');
    }

    public function getTriageColorAttribute(): string
    {
        return match($this->triage_category) {
            'P1 - Merah'  => 'danger',
            'P2 - Kuning' => 'warning',
            'P3 - Hijau'  => 'success',
            'P4 - Hitam'  => 'accent',
            default       => 'info',
        };
    }
}
