<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'schedules';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id',
        'shift_id',
        'office_id',
        'created_at',
        'updated_at',
        'is_wfa',
    ];

    // Jika ada relasi dengan tabel lain, bisa didefinisikan di sini

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Shift
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    // Relasi dengan model Office
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
