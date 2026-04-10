<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Queue;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('admin.registration');
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'nik' => 'nullable|string|max:16',
            'name' => 'required|string|max:100',
            'address' => 'required|string',
            'age' => 'required|integer|min:0|max:150',
            'gender' => 'required|in:L,P',
        ]);

        if ($request->patient_id) {
            $patient = Patient::findOrFail($request->patient_id);
            $patient->update($request->only(['nik', 'name', 'address', 'age', 'gender']));
        }
        else {
            $patient = Patient::create($request->only(['nik', 'name', 'address', 'age', 'gender']));
        }

        $queue = Queue::create([
            'patient_id' => $patient->id,
            'queue_number' => Queue::getNextNumber(),
            'queue_date' => now()->toDateString(),
            'status' => 'waiting',
        ]);

        return redirect()->route('admin.queue.index')
            ->with('success', "Pasien {$patient->name} terdaftar dengan nomor antrian #{$queue->queue_number}");
    }

    public function searchPatient(Request $request)
    {
        $term = $request->get('q', '');
        $patients = Patient::where('name', 'like', "%{$term}%")
            ->orWhere('nik', 'like', "%{$term}%")
            ->limit(10)
            ->get(['id', 'nik', 'name', 'address', 'age', 'gender']);

        return response()->json($patients);
    }
}
