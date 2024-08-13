<?php

namespace App\Models\Karyawan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $connection = 'hrd';

    protected $table = 'hrd.tbl_makar';

    protected $dates = ['tgl_masuk', 'tgl_evaluasi'];

    // Accessor untuk format tanggal
    public function getTglMasukFormattedAttribute()
    {
        return $this->tgl_masuk ? $this->tgl_masuk->format('d F Y') : '-';
    }

    public function getTglEvaluasiFormattedAttribute()
    {
        return $this->tgl_evaluasi ? $this->tgl_evaluasi->format('d F Y') : '-';
    }
}
