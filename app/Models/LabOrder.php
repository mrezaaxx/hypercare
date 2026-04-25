<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabOrder extends Model
{
    protected $fillable = [
        'patient_id',
        'order_number',
        'test_type',
        'clinical_notes',
        'priority',
        'status',
        'result_value',
        'result_notes',
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
