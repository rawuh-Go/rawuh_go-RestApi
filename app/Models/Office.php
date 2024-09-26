<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     *
     * @var string
     */
    protected $table = 'offices';

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'latitude',
        'longitude',
        'radius',
        'created_at',
        'updated_at'
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
        'latitude' => 'float',
        'longitude' => 'float',
        'radius' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
