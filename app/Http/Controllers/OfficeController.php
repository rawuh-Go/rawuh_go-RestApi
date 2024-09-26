<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    /**
     * Menampilkan semua data kantor.
     */
    public function index()
    {
        $offices = Office::all();
        return response()->json($offices);
    }

    /**
     * Menyimpan data kantor baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer',
        ]);

        $office = Office::create([
            'nama' => $request->nama,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return response()->json(['message' => 'Office created successfully!', 'data' => $office], 201);
    }

    /**
     * Menampilkan data kantor berdasarkan ID.
     */
    public function show($id)
    {
        $office = Office::findOrFail($id);
        return response()->json($office);
    }

    /**
     * Memperbarui data kantor.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer',
        ]);

        $office = Office::findOrFail($id);

        $office->update([
            'nama' => $request->nama,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        return response()->json(['message' => 'Office updated successfully!', 'data' => $office], 200);
    }

    /**
     * Menghapus data kantor.
     */
    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        return response()->json(['message' => 'Office deleted successfully!'], 200);
    }
}
