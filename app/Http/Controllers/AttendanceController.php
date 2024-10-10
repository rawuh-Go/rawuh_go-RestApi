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
            'schedule_waktu_datang' => 'required|date_format:H:i:s',
            'schedule_waktu_pulang' => 'required|date_format:H:i:s',
            'datang_latitude' => 'required|numeric',
            'datang_longitude' => 'required|numeric',
            'waktu_datang' => 'required|date_format:H:i:s',
            'foto_absen_datang' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'waktu_pulang' => 'required|date_format:H:i:s',
            'foto_absen_pulang' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan gambar absen datang
        $fotoDatangPath = $request->file('foto_absen_datang')->store('absen_datang', 'public');
        // Simpan gambar absen pulang
        $fotoPulangPath = $request->file('foto_absen_pulang')->store('absen_pulang', 'public');

        $attendance = Attendance::create([
            'user_id' => $request->user_id,
            'schedule_latitude' => $request->schedule_latitude,
            'schedule_longitude' => $request->schedule_longitude,
            'schedule_waktu_datang' => $request->schedule_waktu_datang,
            'schedule_waktu_pulang' => $request->schedule_waktu_pulang,
            'datang_latitude' => $request->datang_latitude,
            'datang_longitude' => $request->datang_longitude,
            'waktu_datang' => $request->waktu_datang,
            'foto_absen_datang' => $fotoDatangPath,
            'waktu_pulang' => $request->waktu_pulang,
            'foto_absen_pulang' => $fotoPulangPath,
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
            'schedule_waktu_datang' => 'required|date_format:H:i:s',
            'schedule_waktu_pulang' => 'required|date_format:H:i:s',
            'datang_latitude' => 'required|numeric',
            'datang_longitude' => 'required|numeric',
            'waktu_datang' => 'required|date_format:H:i:s',
            'foto_absen_datang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'waktu_pulang' => 'required|date_format:H:i:s',
            'foto_absen_pulang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $attendance = Attendance::findOrFail($id);

        // Jika ada gambar absen datang baru, simpan
        if ($request->hasFile('foto_absen_datang')) {
            $fotoDatangPath = $request->file('foto_absen_datang')->store('absen_datang', 'public');
            $attendance->foto_absen_datang = $fotoDatangPath;
            \Log::info('Updated datang photo path:', [$fotoDatangPath]);
        }

        // Jika ada gambar absen pulang baru, simpan
        if ($request->hasFile('foto_absen_pulang')) {
            $fotoPulangPath = $request->file('foto_absen_pulang')->store('absen_pulang', 'public');
            $attendance->foto_absen_pulang = $fotoPulangPath;
            \Log::info('Updated pulang photo path:', [$fotoPulangPath]);
        }

        // Update data lainnya
        $attendance->user_id = $request->user_id;
        $attendance->schedule_latitude = $request->schedule_latitude;
        $attendance->schedule_longitude = $request->schedule_longitude;
        $attendance->schedule_waktu_datang = $request->schedule_waktu_datang;
        $attendance->schedule_waktu_pulang = $request->schedule_waktu_pulang;
        $attendance->datang_latitude = $request->datang_latitude;
        $attendance->datang_longitude = $request->datang_longitude;
        $attendance->waktu_datang = $request->waktu_datang;
        $attendance->waktu_pulang = $request->waktu_pulang;

        // Simpan perubahan
        $attendance->save();
        \Log::info('Attendance updated successfully:', [$attendance]);

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
