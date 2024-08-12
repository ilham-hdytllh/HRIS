<?php

namespace App\Http\Controllers\DashboardController;

use App\Http\Controllers\Controller;
use App\Models\Karyawan\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jml_karyawan = Karyawan::where('status_karyawan', '!=', 'resigned')
            ->where('status_karyawan', '!=', 'perubahan_status')
            ->count();

        $jml_karyawan_pria = Karyawan::where('status_karyawan', '!=', 'resigned')
            ->where('status_karyawan', '!=', 'perubahan_status')
            ->where('jenis_kelamin', 'Laki')
            ->count();

        $jml_karyawan_wanita = Karyawan::
                where('status_karyawan', '!=', 'resigned')
            ->where('status_karyawan', '!=', 'perubahan_status')
            ->where('jenis_kelamin', 'wanita')
            ->count();

        // Menghitung jumlah karyawan dengan status tertentu berdasarkan departemen
        $tot_karyawan = DB::table('hrd.tbl_makar')
            ->join('hrd.dept', 'hrd.tbl_makar.dept', '=', 'dept.code')
            ->where('status_karyawan', '!=', 'resigned')
            ->where('status_karyawan', '!=', 'perubahan_status')
            ->select(DB::raw('dept,dept_name, COUNT(*) as total'))
            ->groupBy('dept','dept_name')
            ->orderBy('dept')
            ->get();
        return view('dashboard', compact('jml_karyawan', 'jml_karyawan_pria', 'jml_karyawan_wanita', 'tot_karyawan'));
    }
}