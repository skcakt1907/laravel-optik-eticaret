<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments', [
            'appointments' => Appointment::latest()->paginate(20),
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'status' => 'required|in:yeni,arandi,tamamlandi,iptal',
        ]);

        // status korumalı alan; admin enum-doğrulamalı olarak forceFill ile yazar.
        $appointment->forceFill($data)->save();

        return back()->with('success', 'Randevu güncellendi.');
    }
}
