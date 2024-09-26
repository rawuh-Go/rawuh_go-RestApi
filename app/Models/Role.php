<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'roles';

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
        'guard_name',
    ];

    // Untuk format datetime (created_at dan updated_at)
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Jika ada relasi ke tabel lain, kamu bisa mendefinisikannya di sini
    // Contoh: Jika role berhubungan dengan user
    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }
}
