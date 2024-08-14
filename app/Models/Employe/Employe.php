<?php

namespace App\Models\Employe;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $connection = 'hrd';

    protected $table = 'hrd.tbl_makar';

    protected $dates = ['tgl_masuk', 'tgl_evaluasi'];
}
