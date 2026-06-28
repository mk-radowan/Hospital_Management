<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'user' => [
                    'name' => 'Dr. Ayesha Khan',
                    'email' => 'ayesha.khan@laramedicare.com',
                    'password' => Hash::make('doctor123'),
                    'phone' => '0300-1234567',
                    'cnic' => '42201-1234567-3',
                    'address' => 'F-7 Markaz, Islamabad, Pakistan',
                    'role' => 'doctor',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Cardiologist',
                    'qualification' => 'MBBS, MD Cardiology',
                    'experience_years' => 8,
                    'consultation_fee' => 2500.00,
                    'license_number' => 'PMC-12345',
                    'available_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
                    'available_time_start' => '09:00',
                    'available_time_end' => '17:00',
                    'is_available' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Ahmed Raza',
                    'email' => 'ahmed.raza@laramedicare.com',
                    'password' => Hash::make('doctor123'),
                    'phone' => '0301-9876543',
                    'cnic' => '42201-9876543-4',
                    'address' => 'Gulberg II, Lahore, Punjab, Pakistan',
                    'role' => 'doctor',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Pediatrician',
                    'qualification' => 'MBBS, DCH',
                    'experience_years' => 5,
                    'consultation_fee' => 2000.00,
                    'license_number' => 'PMC-54321',
                    'available_days' => ['monday', 'wednesday', 'friday', 'saturday'],
                    'available_time_start' => '10:00',
                    'available_time_end' => '16:00',
                    'is_available' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Fatima Malik',
                    'email' => 'fatima.malik@laramedicare.com',
                    'password' => Hash::make('doctor123'),
                    'phone' => '0302-5555555',
                    'cnic' => '42201-5555555-5',
                    'address' => 'Clifton Block 2, Karachi, Sindh, Pakistan',
                    'role' => 'doctor',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Gynecologist',
                    'qualification' => 'MBBS, FCPS Gynecology',
                    'experience_years' => 10,
                    'consultation_fee' => 3000.00,
                    'license_number' => 'PMC-11111',
                    'available_days' => ['tuesday', 'thursday', 'saturday'],
                    'available_time_start' => '14:00',
                    'available_time_end' => '20:00',
                    'is_available' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Zain Ali',
                    'email' => 'zain.ali@laramedicare.com',
                    'password' => Hash::make('doctor123'),
                    'phone' => '0303-7777777',
                    'cnic' => '42201-7777777-6',
                    'address' => 'University Road, Peshawar, KPK, Pakistan',
                    'role' => 'doctor',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Orthopedic Surgeon',
                    'qualification' => 'MBBS, MS Orthopedics',
                    'experience_years' => 12,
                    'consultation_fee' => 3500.00,
                    'license_number' => 'PMC-77777',
                    'available_days' => ['monday', 'tuesday', 'thursday', 'friday'],
                    'available_time_start' => '08:00',
                    'available_time_end' => '14:00',
                    'is_available' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Sadia Hassan',
                    'email' => 'sadia.hassan@laramedicare.com',
                    'password' => Hash::make('doctor123'),
                    'phone' => '0304-8888888',
                    'cnic' => '42201-8888888-7',
                    'address' => 'Johar Town, Lahore, Punjab, Pakistan',
                    'role' => 'doctor',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'Dermatologist',
                    'qualification' => 'MBBS, FCPS Dermatology',
                    'experience_years' => 6,
                    'consultation_fee' => 2200.00,
                    'license_number' => 'PMC-88888',
                    'available_days' => ['monday', 'wednesday', 'friday'],
                    'available_time_start' => '11:00',
                    'available_time_end' => '18:00',
                    'is_available' => true,
                ]
            ],
            [
                'user' => [
                    'name' => 'Dr. Hassan Mahmood',
                    'email' => 'hassan.mahmood@laramedicare.com',
                    'password' => Hash::make('doctor123'),
                    'phone' => '0305-3333333',
                    'cnic' => '42201-3333333-8',
                    'address' => 'North Nazimabad, Karachi, Sindh, Pakistan',
                    'role' => 'doctor',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'specialization' => 'General Physician',
                    'qualification' => 'MBBS',
                    'experience_years' => 3,
                    'consultation_fee' => 1500.00,
                    'license_number' => 'PMC-33333',
                    'available_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
                    'available_time_start' => '09:00',
                    'available_time_end' => '21:00',
                    'is_available' => true,
                ]
            ],
        ];

        foreach ($doctors as $doctorData) {
            $user = User::create($doctorData['user']);
            Doctor::create(array_merge($doctorData['profile'], ['user_id' => $user->id]));
        }
    }
}