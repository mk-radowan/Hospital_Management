<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LegacyAdminController extends Controller
{
    public function index()
    {
        $featureGroups = [
            [
                'title' => 'Accounts and Finance',
                'features' => [
                    'Admin Account',
                    'Accounting Records',
                    'Payable Accounts',
                    'Receivable Accounts',
                    'Vendors',
                    'Payroll Generation',
                ],
            ],
            [
                'title' => 'Employee and Department',
                'features' => [
                    'Employee Records',
                    'Assign Department',
                    'Employee Transfer',
                    'Employee Vitals',
                ],
            ],
            [
                'title' => 'Pharmacy and Inventory',
                'features' => [
                    'Pharmacy Categories',
                    'Pharmaceutical Records',
                    'Pharmacy Inventory',
                    'Equipment Inventory',
                    'Lab Equipment',
                ],
            ],
            [
                'title' => 'Medical and Lab',
                'features' => [
                    'Medical Records',
                    'Lab Tests',
                    'Lab Results',
                    'Patient Vitals',
                    'Prescriptions',
                ],
            ],
            [
                'title' => 'Patient Operations',
                'features' => [
                    'Inpatient and Outpatient Records',
                    'Patient Transfer',
                    'Discharge Workflow',
                    'Surgery Records',
                    'Theatre Management',
                ],
            ],
        ];

        return view('admin.legacy.index', compact('featureGroups'));
    }
}
