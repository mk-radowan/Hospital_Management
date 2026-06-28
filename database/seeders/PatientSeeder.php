<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'user' => [
                    'name' => 'Ali Hassan',
                    'email' => 'ali.hassan@email.com',
                    'password' => Hash::make('patient123'),
                    'phone' => '0311-1111111',
                    'cnic' => '42301-1111111-1',
                    'address' => 'Saddar Town, Karachi, Sindh, Pakistan',
                    'role' => 'patient',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'date_of_birth' => '1990-05-15',
                    'gender' => 'male',
                    'blood_group' => 'B+',
                    'emergency_contact' => '0321-2222222',
                    'medical_history' => 'Hypertension, controlled with medication.',
                ]
            ],
            [
                'user' => [
                    'name' => 'Fatima Noor',
                    'email' => 'fatima.noor@email.com',
                    'password' => Hash::make('patient123'),
                    'phone' => '0312-3333333',
                    'cnic' => '42301-3333333-2',
                    'address' => 'Model Town, Lahore, Punjab, Pakistan',
                    'role' => 'patient',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'date_of_birth' => '1985-12-20',
                    'gender' => 'female',
                    'blood_group' => 'A+',
                    'emergency_contact' => '0322-4444444',
                    'medical_history' => 'Diabetes Type 2, regular check-ups required.',
                ]
            ],
            [
                'user' => [
                    'name' => 'Muhammad Usman',
                    'email' => 'usman.ahmed@email.com',
                    'password' => Hash::make('patient123'),
                    'phone' => '0313-5555555',
                    'cnic' => '42301-5555555-3',
                    'address' => 'F-10 Markaz, Islamabad, Pakistan',
                    'role' => 'patient',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'date_of_birth' => '1992-08-10',
                    'gender' => 'male',
                    'blood_group' => 'O+',
                    'emergency_contact' => '0323-6666666',
                    'medical_history' => 'Asthma, uses inhaler as needed.',
                ]
            ],
            [
                'user' => [
                    'name' => 'Aisha Khan',
                    'email' => 'aisha.khan@email.com',
                    'password' => Hash::make('patient123'),
                    'phone' => '0314-7777777',
                    'cnic' => '42301-7777777-4',
                    'address' => 'Gulshan-e-Iqbal, Karachi, Sindh, Pakistan',
                    'role' => 'patient',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'date_of_birth' => '1988-03-25',
                    'gender' => 'female',
                    'blood_group' => 'AB+',
                    'emergency_contact' => '0324-8888888',
                    'medical_history' => 'Migraine, takes medication during episodes.',
                ]
            ],
            [
                'user' => [
                    'name' => 'Tariq Mahmood',
                    'email' => 'tariq.mahmood@email.com',
                    'password' => Hash::make('patient123'),
                    'phone' => '0315-9999999',
                    'cnic' => '42301-9999999-5',
                    'address' => 'Hayatabad, Peshawar, KPK, Pakistan',
                    'role' => 'patient',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'date_of_birth' => '1975-11-05',
                    'gender' => 'male',
                    'blood_group' => 'A-',
                    'emergency_contact' => '0325-1010101',
                    'medical_history' => 'Heart disease, regular cardiac check-ups.',
                ]
            ],
            [
                'user' => [
                    'name' => 'Zara Sheikh',
                    'email' => 'zara.sheikh@email.com',
                    'password' => Hash::make('patient123'),
                    'phone' => '0316-1212121',
                    'cnic' => '42301-1212121-6',
                    'address' => 'DHA Phase 1, Lahore, Punjab, Pakistan',
                    'role' => 'patient',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'date_of_birth' => '1995-07-18',
                    'gender' => 'female',
                    'blood_group' => 'O-',
                    'emergency_contact' => '0326-1313131',
                    'medical_history' => 'No significant medical history.',
                ]
            ],
            [
                'user' => [
                    'name' => 'Bilal Ahmad',
                    'email' => 'bilal.ahmad@email.com',
                    'password' => Hash::make('patient123'),
                    'phone' => '0317-1414141',
                    'cnic' => '42301-1414141-7',
                    'address' => 'Satellite Town, Rawalpindi, Punjab, Pakistan',
                    'role' => 'patient',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'date_of_birth' => '1987-01-12',
                    'gender' => 'male',
                    'blood_group' => 'B-',
                    'emergency_contact' => '0327-1515151',
                    'medical_history' => 'Allergic to penicillin.',
                ]
            ],
            [
                'user' => [
                    'name' => 'Mehreen Ali',
                    'email' => 'mehreen.ali@email.com',
                    'password' => Hash::make('patient123'),
                    'phone' => '0318-1616161',
                    'cnic' => '42301-1616161-8',
                    'address' => 'Cantt Area, Multan, Punjab, Pakistan',
                    'role' => 'patient',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'date_of_birth' => '1993-09-30',
                    'gender' => 'female',
                    'blood_group' => 'AB-',
                    'emergency_contact' => '0328-1717171',
                    'medical_history' => 'Thyroid disorder, on medication.',
                ]
            ],
        ];

        foreach ($patients as $patientData) {
            $user = User::create($patientData['user']);
            Patient::create(array_merge($patientData['profile'], ['user_id' => $user->id]));
        }
    }
}