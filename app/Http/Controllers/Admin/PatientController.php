<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $patients = Patient::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%");
        })
            ->orderBy('name')
            ->paginate(15)
            ->appends(['search' => $search]);

        return view('admin.patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('admin.patients.form', ['patient' => new Patient()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'nullable|string|max:16',
            'name' => 'required|string|max:100',
            'address' => 'required|string',
            'age' => 'required|integer|min:0|max:150',
            'gender' => 'required|in:L,P',
        ]);

        Patient::create($request->only(['nik', 'name', 'address', 'age', 'gender']));

        return redirect()->route('admin.patients.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.form', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'nik' => 'nullable|string|max:16',
            'name' => 'required|string|max:100',
            'address' => 'required|string',
            'age' => 'required|integer|min:0|max:150',
            'gender' => 'required|in:L,P',
        ]);

        $patient->update($request->only(['nik', 'name', 'address', 'age', 'gender']));

        return redirect()->route('admin.patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}
