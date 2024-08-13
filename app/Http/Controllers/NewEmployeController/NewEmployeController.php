<?php

namespace App\Http\Controllers\NewEmployeController;

use App\Http\Controllers\Controller;
use App\Models\Karyawan\Karyawan;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class NewEmployeController extends Controller
{
    public function index()
    {
        $user = Auth::user()->username;
        $dept = Auth::user()->dept;

        // Memastikan informasi `user` ada di session
        if (!$user || !$dept) {
            return response()->json(['error' => 'User or department information is missing from the session'], 400);
        }

        if ($user == "iso.hrd") {
            $dept_employes = Karyawan::select([
                'no_scan',
                'nama',
                'dept',
                'tgl_masuk',
                'tgl_evaluasi',
                DB::raw("FORMAT(tgl_masuk, 'dd MMMM yyyy') AS ftgl_masuk"),
                DB::raw("CASE 
                                WHEN tgl_evaluasi IS NOT NULL AND tgl_evaluasi <> '' THEN FORMAT(tgl_evaluasi, 'dd MMMM yyyy') 
                                ELSE '-' 
                             END AS ftgl_evaluasi"),
                'jabatan',
                'status_email_kontrak'
            ])
                ->whereNotIn('status_karyawan', ['Resigned', 'perubahan_status'])
                ->whereBetween('tgl_evaluasi', ['2024-03-03', DB::raw('DATEADD(MONTH, 12, tgl_evaluasi)')])
                ->where('status_email_kontrak', 2)
                ->orderBy('tgl_masuk', 'DESC')
                ->get();
        } else {
            $dept_employes = Karyawan::select([
                'no_scan',
                'nama',
                'dept',
                'tgl_masuk',
                'tgl_evaluasi',
                DB::raw("FORMAT(tgl_masuk, 'dd MMMM yyyy') AS ftgl_masuk"),
                DB::raw("CASE 
                                WHEN tgl_evaluasi IS NOT NULL AND tgl_evaluasi <> '' THEN FORMAT(tgl_evaluasi, 'dd MMMM yyyy') 
                                ELSE '-' 
                             END AS ftgl_evaluasi"),
                'jabatan',
                'status_email_kontrak'
            ])
                ->whereNotIn('status_karyawan', ['Resigned', 'perubahan_status'])
                ->whereBetween('tgl_evaluasi', ['2024-03-03', DB::raw('DATEADD(MONTH, 12, tgl_evaluasi)')])
                ->where('dept', $dept)
                ->orderBy('tgl_masuk', 'DESC')
                ->get();
        }

        $all_employes = Karyawan::select([
            'no_scan',
            'nama',
            'dept',
            'tgl_masuk',
            'tgl_evaluasi',
            DB::raw("FORMAT(tgl_masuk, 'dd MMMM yyyy') AS ftgl_masuk"),
            DB::raw("CASE 
                                WHEN tgl_evaluasi IS NOT NULL AND tgl_evaluasi <> '' THEN FORMAT(tgl_evaluasi, 'dd MMMM yyyy') 
                                ELSE '-' 
                             END AS ftgl_evaluasi"),
            'jabatan',
            'status_email_kontrak'
        ])
            ->whereNotIn('status_karyawan', ['Resigned', 'perubahan_status'])
            ->whereBetween('tgl_evaluasi', ['2024-03-03', DB::raw('DATEADD(MONTH, 12, tgl_evaluasi)')])
            ->whereNull('status_email_kontrak')
            ->orderBy('tgl_masuk', 'DESC')
            ->get();

        return view('new_employe.new_employe', compact('dept_employes', 'all_employes'));
    }
}
