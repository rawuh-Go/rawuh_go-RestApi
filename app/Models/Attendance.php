<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     *
     * @var string
     */
    protected $table = 'attendances';

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'schedule_latitude',
        'schedule_longitude',
        'schedule_waktu_datang',
        'schedule_waktu_pulang',
        'datang_latitude',
        'datang_longitude',
        'waktu_datang',
        'foto_absen_datang',
        'waktu_pulang',
        'foto_absen_pulang', // Pastikan ini ada
    ];

    /**
     * Nonaktifkan penggunaan soft delete jika tidak diperlukan
     */
    public $timestamps = true;

    /**
     * Kolom-kolom yang harus dikonversi menjadi tipe data yang sesuai.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'schedule_latitude' => 'float',
        'schedule_longitude' => 'float',
        'datang_latitude' => 'float',
        'datang_longitude' => 'float',
        'waktu_datang' => 'datetime',
        'waktu_pulang' => 'datetime',
        'schedule_waktu_datang' => 'datetime:H:i:s',
        'schedule_waktu_pulang' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
