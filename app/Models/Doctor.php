<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization',
        'qualification',
        'experience_years',
        'consultation_fee',
        'license_number',
        'available_days',
        'available_time_start',
        'available_time_end',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'available_days' => 'array',
            'consultation_fee' => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function isAvailableOnDay($day)
    {
        return in_array($day, $this->available_days ?? []);
    }
    
}