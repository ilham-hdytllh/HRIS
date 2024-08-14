<?php

namespace App\Http\Controllers\NewEmployeController;

use App\Http\Controllers\Controller;
use App\Mail\EvaluationEmail;
use App\Models\Employe\Employe;
use App\Models\Karyawan\Karyawan;
use Exception;
use Flasher\Toastr\Prime\ToastrFactory;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\isNull;

class NewEmployeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->username;
        $dept = Auth::user()->dept;


        // Ambil parameter filter dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Memastikan informasi `user` ada di session
        if (!$user || !$dept) {
            return response()->json(['error' => 'User or department information is missing from the session'], 400);
        }

        if ($user == "iso.hrd") {
            $dept_employes = Employe::select([
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
            $dept_employes = Employe::select([
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

        $all_employes = Employe::select([
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

    public function sendMailNewEmploye(Request $request, ToastrFactory $flasher)
    {
        try {
            // Validasi apakah ada checkbox yang dipilih
            $request->validate([
                'no_scan' => 'required|array|min:1',
                'no_scan.*' => 'string'
            ]);

            // Mengambil array nilai checkbox yang dipilih
            $selectedItems = $request->input('no_scan', []);

            // Konversi array string menjadi array asosiatif
            $data_employe = array_map(function ($item) {
                list($no_scan, $nama, $dept, $tgl_masuk, $tgl_evaluasi, $jabatan) = explode('/', $item);
                return [
                    'no_scan' => $no_scan,
                    'nama' => $nama,
                    'dept' => $dept,
                    'tgl_masuk' => $tgl_masuk,
                    'tgl_evaluasi' => $tgl_evaluasi,
                    'jabatan' => $jabatan,
                ];
            }, $selectedItems);

            // Ambil semua departemen dari data employe
            $departments = array_column($data_employe, 'dept');

            // Hapus duplikasi departemen
            $unique_departments = array_unique($departments);

            if (count($unique_departments) > 1) {
                // Tangani kesalahan dan tampilkan pesan kesalahan
                $flasher->addError('Departemen yang dipilih tidak boleh berbeda!');
                return back(); // Kembali ke halaman sebelumnya
            }

            if ($unique_departments[0] == 'MKT') {
                $cc_mail = [
                    // 'irwan.mulyadi@indotaichen.com',
                    // 'bunbun@indotaichen.com',
                    // 'bambang@indotaichen.com',
                    // 'frans@indotaichen.com',
                    // 'suhemi@indotaichen.com',
                    // 'stefanus.pranjana@indotaichen.com',
                    // 'Hrd@indotaichen.com',
                    'asep.pauji@indotaichen.com',
                    // $dept_mail1,
                    // $dept_mail2,
                    // $dept_mail3,
                    // $dept_mail4
                ];
            } else {
                $cc_mail = [
                    // 'stefanus.pranjana@indotaichen.com',
                    // 'Hrd@indotaichen.com',
                    // 'asep.pauji@indotaichen.com',
                    // $dept_mail1,
                    // $dept_mail2,
                    // $dept_mail3,
                    // $dept_mail4
                ];
            }

            // Kirim email
            // Iso.hrd@indotaichen.com
            Mail::to('ilham.hidayatullah@indotaichen.com')
                ->cc($cc_mail)
                ->send(new EvaluationEmail($data_employe));

            // Toast sukses
            $flasher->addSuccess('Success sending email');
        } catch (Exception $e) {
            // Tangani kesalahan dan tampilkan pesan kesalahan
            $flasher->addError('Error sending email: ' . $e->getMessage());
        }

        return back();
    }
}
