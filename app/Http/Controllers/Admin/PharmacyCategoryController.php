<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PharmacyCategory;
use Illuminate\Http\Request;

class PharmacyCategoryController extends Controller
{
    public function index()
    {
        $categories = PharmacyCategory::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pharmacy-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pharmacy-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:pharmacy_categories,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        PharmacyCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.pharmacy-categories.index')
            ->with('success', 'Pharmacy category created successfully.');
    }

    public function edit(PharmacyCategory $pharmacyCategory)
    {
        return view('admin.pharmacy-categories.edit', compact('pharmacyCategory'));
    }

    public function update(Request $request, PharmacyCategory $pharmacyCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:pharmacy_categories,name,' . $pharmacyCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $pharmacyCategory->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.pharmacy-categories.index')
            ->with('success', 'Pharmacy category updated successfully.');
    }

    public function destroy(PharmacyCategory $pharmacyCategory)
    {
        $pharmacyCategory->delete();

        return redirect()->route('admin.pharmacy-categories.index')
            ->with('success', 'Pharmacy category deleted successfully.');
    }

    public function toggleStatus(PharmacyCategory $pharmacyCategory)
    {
        $pharmacyCategory->update([
            'is_active' => !$pharmacyCategory->is_active,
        ]);

        $status = $pharmacyCategory->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Pharmacy category {$status} successfully.");
    }
}
