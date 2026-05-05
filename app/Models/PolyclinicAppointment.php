<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PolyclinicAppointment extends Model
{
    protected $fillable = [
        'appointment_number',
        'patient_id',
        'doctor_schedule_id',
        'appointment_date',
        'queue_number',
        'status',
        'complaint',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctorSchedule()
    {
        return $this->belongsTo(DoctorSchedule::class);
    }
}
