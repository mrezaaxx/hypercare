<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RadiologyOrder extends Model
{
    protected $fillable = [
        'patient_id',
        'order_number',
        'exam_type',
        'body_part',
        'clinical_notes',
        'priority',
        'status',
        'result_findings',
        'result_impression',
        'ordered_by',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function orderedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ordered_by');
    }
}
