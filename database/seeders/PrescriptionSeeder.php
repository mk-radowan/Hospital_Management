<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prescription;
use App\Models\Appointment;

class PrescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get completed appointments only
        $completedAppointments = Appointment::where('status', 'completed')
            ->with(['patient', 'doctor'])
            ->get();

        $samplePrescriptions = [
            [
                'diagnosis' => 'Hypertension',
                'medications' => [
                    'Amlodipine 5mg - Once daily',
                    'Metoprolol 50mg - Twice daily',
                    'Aspirin 75mg - Once daily'
                ],
                'instructions' => 'Take medications as prescribed. Monitor blood pressure daily. Avoid salt and maintain regular exercise. Follow up in 2 weeks.'
            ],
            [
                'diagnosis' => 'Upper Respiratory Tract Infection',
                'medications' => [
                    'Amoxicillin 500mg - Three times daily for 7 days',
                    'Paracetamol 500mg - As needed for fever',
                    'Cough syrup - 5ml three times daily'
                ],
                'instructions' => 'Complete the antibiotic course. Take plenty of fluids and rest. Return if symptoms worsen.'
            ],
            [
                'diagnosis' => 'Allergic Dermatitis',
                'medications' => [
                    'Cetirizine 10mg - Once daily',
                    'Hydrocortisone cream - Apply twice daily',
                    'Moisturizing lotion - Apply as needed'
                ],
                'instructions' => 'Avoid known allergens. Apply cream to affected areas only. Keep skin moisturized.'
            ],
            [
                'diagnosis' => 'Type 2 Diabetes Mellitus',
                'medications' => [
                    'Metformin 500mg - Twice daily with meals',
                    'Glibenclamide 5mg - Once daily before breakfast'
                ],
                'instructions' => 'Monitor blood sugar levels regularly. Follow diabetic diet. Exercise 30 minutes daily. Regular follow-up required.'
            ],
            [
                'diagnosis' => 'Migraine Headache',
                'medications' => [
                    'Sumatriptan 50mg - As needed during attack',
                    'Propranolol 40mg - Twice daily for prevention',
                    'Paracetamol 500mg - As needed for pain'
                ],
                'instructions' => 'Identify and avoid triggers. Take medication at onset of symptoms. Maintain regular sleep schedule.'
            ],
            [
                'diagnosis' => 'Osteoarthritis',
                'medications' => [
                    'Ibuprofen 400mg - Three times daily with food',
                    'Glucosamine 500mg - Twice daily',
                    'Topical diclofenac gel - Apply twice daily'
                ],
                'instructions' => 'Apply gel to affected joints. Gentle exercise as tolerated. Weight management important. Physiotherapy recommended.'
            ],
        ];

        foreach ($completedAppointments as $appointment) {
            $prescriptionData = collect($samplePrescriptions)->random();
            
            Prescription::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'diagnosis' => $prescriptionData['diagnosis'],
                'medications' => $prescriptionData['medications'],
                'instructions' => $prescriptionData['instructions'],
                'prescription_date' => $appointment->appointment_date,
            ]);
        }
    }
}