<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans';

    protected $fillable = ['tgl_mulai', 'tgl_akhir', 'total_harga', 'mobil_id'];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengembalian()
    {
        return $this->hasMany(Pengembalian::class);
    }
}
