<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $clinicName = Setting::get('clinic_name', 'Bidan Mandiri');
        return view('admin.settings', compact('clinicName'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255',
        ]);

        Setting::set('clinic_name', $request->clinic_name);

        return redirect()->route('admin.settings.index')->with('success', 'Identitas Kiosk berhasil diperbarui!');
    }

    public function updateSecurity(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.settings.index')->with('success', 'Profil dan Keamanan Akun berhasil diperbarui!');
    }
}
