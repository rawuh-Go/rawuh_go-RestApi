<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Menampilkan semua data absensi.
     */
    public function index()
    {
        $attendances = Attendance::all();
        return response()->json($attendances);
    }

    /**
     * Menyimpan data absensi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'schedule_latitude' => 'required|numeric',
            'schedule_longitude' => 'required|numeric',
            'schedule_waktu_datang' => 'required',
            'schedule_waktu_pulang' => 'required',
            'datang_latitude' => 'required|numeric',
            'datang_longitude' => 'required|numeric',
            'waktu_datang' => 'required',
            'waktu_pulang' => 'required',
        ]);

        $attendance = Attendance::create([
            'user_id' => $request->user_id,
            'schedule_latitude' => $request->schedule_latitude,
            'schedule_longitude' => $request->schedule_longitude,
            'schedule_waktu_datang' => $request->schedule_waktu_datang,
            'schedule_waktu_pulang' => $request->schedule_waktu_pulang,
            'datang_latitude' => $request->datang_latitude,
            'datang_longitude' => $request->datang_longitude,
            'waktu_datang' => $request->waktu_datang,
            'waktu_pulang' => $request->waktu_pulang,
        ]);

        return response()->json(['message' => 'Attendance created successfully!', 'data' => $attendance], 201);
    }

    /**
     * Menampilkan data absensi berdasarkan ID.
     */
    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);
        return response()->json($attendance);
    }

    /**
     * Memperbarui data absensi.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'schedule_latitude' => 'required|numeric',
            'schedule_longitude' => 'required|numeric',
            'schedule_waktu_datang' => 'required',
            'schedule_waktu_pulang' => 'required',
            'datang_latitude' => 'required|numeric',
            'datang_longitude' => 'required|numeric',
            'waktu_datang' => 'required',
            'waktu_pulang' => 'required',
        ]);

        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            'user_id' => $request->user_id,
            'schedule_latitude' => $request->schedule_latitude,
            'schedule_longitude' => $request->schedule_longitude,
            'schedule_waktu_datang' => $request->schedule_waktu_datang,
            'schedule_waktu_pulang' => $request->schedule_waktu_pulang,
            'datang_latitude' => $request->datang_latitude,
            'datang_longitude' => $request->datang_longitude,
            'waktu_datang' => $request->waktu_datang,
            'waktu_pulang' => $request->waktu_pulang,
        ]);

        return response()->json(['message' => 'Attendance updated successfully!', 'data' => $attendance], 200);
    }

    /**
     * Menghapus data absensi.
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted successfully!'], 200);
    }
}
