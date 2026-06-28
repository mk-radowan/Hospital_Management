<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        if ($doctors->isEmpty() || $patients->isEmpty()) {
            return;
        }

        $appointments = [
            // Past appointments
            [
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->subDays(5)->toDateString(),
                'appointment_time' => Carbon::now()->subDays(5)->setTime(10, 0),
                'status' => 'completed',
                'symptoms' => 'Chest pain and shortness of breath',
                'notes' => 'ECG performed, advised rest and medication',
                'consultation_fee' => 2500.00,
            ],
            [
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->subDays(10)->toDateString(),
                'appointment_time' => Carbon::now()->subDays(10)->setTime(14, 30),
                'status' => 'completed',
                'symptoms' => 'Fever and cough for 3 days',
                'notes' => 'Prescribed antibiotics and rest',
                'consultation_fee' => 1500.00,
            ],
            [
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->subDays(15)->toDateString(),
                'appointment_time' => Carbon::now()->subDays(15)->setTime(16, 0),
                'status' => 'completed',
                'symptoms' => 'Skin rash on arms',
                'notes' => 'Allergic reaction, prescribed antihistamine',
                'consultation_fee' => 2200.00,
            ],
            
            // Upcoming appointments
            [
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->addDays(2)->toDateString(),
                'appointment_time' => Carbon::now()->addDays(2)->setTime(11, 0),
                'status' => 'confirmed',
                'symptoms' => 'Regular checkup',
                'notes' => null,
                'consultation_fee' => 2000.00,
            ],
            [
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->addDays(3)->toDateString(),
                'appointment_time' => Carbon::now()->addDays(3)->setTime(15, 30),
                'status' => 'pending',
                'symptoms' => 'Joint pain in knees',
                'notes' => null,
                'consultation_fee' => 3500.00,
            ],
            [
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->addDays(5)->toDateString(),
                'appointment_time' => Carbon::now()->addDays(5)->setTime(9, 0),
                'status' => 'confirmed',
                'symptoms' => 'Pregnancy consultation',
                'notes' => null,
                'consultation_fee' => 3000.00,
            ],
            
            // Today's appointments
            [
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->toDateString(),
                'appointment_time' => Carbon::now()->setTime(10, 30),
                'status' => 'confirmed',
                'symptoms' => 'Headache and dizziness',
                'notes' => null,
                'consultation_fee' => 1500.00,
            ],
            [
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'appointment_date' => Carbon::now()->toDateString(),
                'appointment_time' => Carbon::now()->setTime(14, 0),
                'status' => 'pending',
                'symptoms' => 'Back pain',
                'notes' => null,
                'consultation_fee' => 3500.00,
            ],
        ];

        foreach ($appointments as $appointment) {
            // Make sure the doctor exists and get their consultation fee
            $doctor = Doctor::find($appointment['doctor_id']);
            if ($doctor) {
                $appointment['consultation_fee'] = $doctor->consultation_fee;
            }
            
            Appointment::create($appointment);
        }

        // Create some additional random appointments
        for ($i = 0; $i < 15; $i++) {
            $doctor = $doctors->random();
            $patient = $patients->random();
            $date = Carbon::now()->addDays(rand(-30, 30));
            
            // Determine status based on date
            $status = 'pending';
            if ($date->isPast()) {
                $status = rand(0, 1) ? 'completed' : 'cancelled';
            } else {
                $status = rand(0, 1) ? 'confirmed' : 'pending';
            }

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => $date->toDateString(),
                'appointment_time' => $date->setTime(rand(9, 17), rand(0, 1) * 30),
                'status' => $status,
                'symptoms' => collect([
                    'Regular checkup',
                    'Fever and cold',
                    'Stomach pain',
                    'Headache',
                    'Muscle pain',
                    'Skin problems',
                    'Blood pressure check',
                    'Diabetes consultation',
                    'Follow-up visit',
                ])->random(),
                'notes' => $status === 'completed' ? 'Treatment provided successfully' : null,
                'consultation_fee' => $doctor->consultation_fee,
            ]);
        }
    }
}