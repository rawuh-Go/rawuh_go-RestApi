<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'nullable|string|max:10',           // Validasi gender
            'address' => 'nullable|string|max:255',         // Validasi alamat
            'phone_number' => 'nullable|string|max:15',     // Validasi nomor telepon
            'country' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
            'job_position' => 'nullable|string|max:255', // Validasi untuk jabatan
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Dapatkan nama file tanpa path
            $fileName = $request->file('image')->getClientOriginalName(); // Ambil nama file asli
            // Simpan gambar ke dalam folder storage/app/public/photoProfile
            $request->file('image')->storeAs('public/photoProfile', $fileName);
            $imagePath = 'storage/photoProfile/' . $fileName; // Simpan path gambar untuk ditampilkan
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'image' => $imagePath, // Simpan path gambar ke database
            'job_position' => $request->job_position, // Simpan jabatan
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.$id,
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'country' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
            'job_position' => 'nullable|string|max:255', // Validasi untuk jabatan
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->name = $request->get('name', $user->name);
        $user->email = $request->get('email', $user->email);
        $user->gender = $request->get('gender', $user->gender);
        $user->address = $request->get('address', $user->address);
        $user->phone_number = $request->get('phone_number', $user->phone_number);
        $user->country = $request->get('country', $user->country);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            // Dapatkan nama file tanpa path
            $fileName = $request->file('image')->getClientOriginalName(); // Ambil nama file asli
            // Simpan gambar ke dalam folder storage/app/public/photoProfile
            $request->file('image')->storeAs('public/photoProfile', $fileName);
            $user->image = 'storage/photoProfile/' . $fileName; // Simpan path gambar untuk ditampilkan
        }

        $user->job_position = $request->get('job_position', $user->job_position);

        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
