<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Mengambil semua data schedule
        $schedules = Schedule::with(['user', 'shift', 'office'])->get();
        return response()->json($schedules);
    }

    /**
     * Store a newly created schedule in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|integer',
            'shift_id' => 'required|integer',
            'office_id' => 'required|integer',
            'is_wfa' => 'required|boolean',
            'is_banned' => 'required|boolean',
        ]);

        // Membuat jadwal baru
        $schedule = Schedule::create([
            'user_id' => $request->user_id,
            'shift_id' => $request->shift_id,
            'office_id' => $request->office_id,
            'is_wfa' => $request->is_wfa,
            'is_banned' => $request->is_banned,
        ]);

        return response()->json([
            'message' => 'Schedule created successfully!',
            'data' => $schedule
        ], 201);
    }

    /**
     * Display the specified schedule.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Mencari schedule berdasarkan ID
        $schedule = Schedule::with(['user', 'shift', 'office'])->find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        return response()->json($schedule);
    }

    /**
     * Update the specified schedule in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'sometimes|required|integer',
            'shift_id' => 'sometimes|required|integer',
            'office_id' => 'sometimes|required|integer',
            'is_wfa' => 'sometimes|required|boolean',
            'is_banned' => 'sometimes|required|boolean',
        ]);

        // Mencari schedule berdasarkan ID
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        // Update schedule
        $schedule->update($request->only(['user_id', 'shift_id', 'office_id', 'is_wfa', 'is_banned']));

        return response()->json([
            'message' => 'Schedule updated successfully!',
            'data' => $schedule
        ]);
    }

    /**
     * Remove the specified schedule from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Mencari schedule berdasarkan ID
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found'], 404);
        }

        // Menghapus schedule
        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
