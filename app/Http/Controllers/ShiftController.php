<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the shifts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mendapatkan semua shift
        $shifts = Shift::all();
        return response()->json($shifts);
    }

    /**
     * Store a newly created shift in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'waktu_datang' => 'required|date_format:H:i:s',
            'waktu_pulang' => 'required|date_format:H:i:s',
        ]);

        // Membuat shift baru
        $shift = Shift::create([
            'nama' => $request->nama,
            'waktu_datang' => $request->waktu_datang,
            'waktu_pulang' => $request->waktu_pulang,
        ]);

        return response()->json([
            'message' => 'Shift created successfully!',
            'data' => $shift
        ], 201);
    }

    /**
     * Display the specified shift.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Mendapatkan shift berdasarkan ID
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json(['message' => 'Shift not found'], 404);
        }

        return response()->json($shift);
    }

    /**
     * Update the specified shift in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'waktu_datang' => 'sometimes|required|date_format:H:i:s',
            'waktu_pulang' => 'sometimes|required|date_format:H:i:s',
        ]);

        // Mendapatkan shift berdasarkan ID
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json(['message' => 'Shift not found'], 404);
        }

        // Update data shift
        $shift->update($request->only(['nama', 'waktu_datang', 'waktu_pulang']));

        return response()->json([
            'message' => 'Shift updated successfully!',
            'data' => $shift
        ]);
    }

    /**
     * Remove the specified shift from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mendapatkan shift berdasarkan ID
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json(['message' => 'Shift not found'], 404);
        }

        // Menghapus shift
        $shift->delete();

        return response()->json(['message' => 'Shift deleted successfully']);
    }
}
