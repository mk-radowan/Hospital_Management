<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Settings
    |--------------------------------------------------------------------------
    */

    'app_name' => 'Hospitally',
    'app_description' => 'Hospital & Clinic Management System for Pakistan',
    
    /*
    |--------------------------------------------------------------------------
    | Pakistani Specific Settings
    |--------------------------------------------------------------------------
    */

    'currency' => [
        'code' => 'PKR',
        'symbol' => '₨',
        'format' => '₨ %s',
    ],

    'phone_format' => [
        'pattern' => '/^03\d{2}-\d{7}$/',
        'example' => '03XX-XXXXXXX',
    ],

    'cnic_format' => [
        'pattern' => '/^\d{5}-\d{7}-\d{1}$/',
        'example' => 'XXXXX-XXXXXXX-X',
    ],

    /*
    |--------------------------------------------------------------------------
    | Appointment Settings
    |--------------------------------------------------------------------------
    */

    'appointments' => [
        'slot_duration' => 30, // minutes
        'advance_booking_days' => 30, // how many days ahead patients can book
        'cancellation_hours' => 2, // minimum hours before appointment to cancel
        'default_consultation_fee' => 1000, // PKR
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    */

    'uploads' => [
        'prescriptions' => [
            'disk' => 'public',
            'path' => 'prescriptions',
            'max_size' => 2048, // KB
            'allowed_types' => ['pdf'],
        ],
        'profile_pictures' => [
            'disk' => 'public',
            'path' => 'profiles',
            'max_size' => 1024, // KB
            'allowed_types' => ['jpg', 'jpeg', 'png'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pakistani Cities
    |--------------------------------------------------------------------------
    */

    'cities' => [
        'Karachi',
        'Lahore', 
        'Islamabad',
        'Rawalpindi',
        'Faisalabad',
        'Multan',
        'Peshawar',
        'Quetta',
        'Sialkot',
        'Gujranwala',
        'Hyderabad',
        'Sargodha',
        'Bahawalpur',
        'Sukkur',
        'Larkana',
        'Mardan',
        'Mingora',
        'Rahim Yar Khan',
        'Sahiwal',
        'Okara',
    ],

    /*
    |--------------------------------------------------------------------------
    | Medical Specializations
    |--------------------------------------------------------------------------
    */

    'specializations' => [
        'General Physician',
        'Cardiologist',
        'Dermatologist',
        'ENT Specialist',
        'Gynecologist',
        'Neurologist',
        'Orthopedic Surgeon',
        'Pediatrician',
        'Psychiatrist',
        'Urologist',
        'Gastroenterologist',
        'Pulmonologist',
        'Oncologist',
        'Ophthalmologist',
        'Radiologist',
        'Pathologist',
        'Anesthesiologist',
        'Emergency Medicine',
        'Family Medicine',
        'Internal Medicine',
    ],

    /*
    |--------------------------------------------------------------------------
    | Blood Groups
    |--------------------------------------------------------------------------
    */

    'blood_groups' => [
        'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
    ],

    /*
    |--------------------------------------------------------------------------
    | Days of Week
    |--------------------------------------------------------------------------
    */

    'days_of_week' => [
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
        'sunday' => 'Sunday',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        'mail' => [
            'appointment_booked' => true,
            'appointment_confirmed' => true,
            'appointment_reminder' => true,
            'appointment_cancelled' => true,
            'prescription_ready' => true,
        ],
        
        'reminder_hours_before' => 24, // Send reminder 24 hours before appointment
    ],

    /*
    |--------------------------------------------------------------------------
    | System Settings
    |--------------------------------------------------------------------------
    */

    'system' => [
        'pagination_per_page' => 15,
        'max_login_attempts' => 5,
        'session_lifetime' => 120, // minutes
        'backup_frequency' => 'daily',
    ],

];