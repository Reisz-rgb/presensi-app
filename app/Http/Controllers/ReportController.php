<?php

namespace App\Http\Controllers;

use App\Exports\PresensiExport;
use App\Models\Presensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $pegawaiId = $request->pegawai_id;

        $filename = 'Laporan_Presensi_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new PresensiExport($startDate, $endDate, $pegawaiId),
            $filename
        );
    }

    public function index(Request $request)
    {
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-d');
        $pegawaiId = $request->pegawai_id ?? 'all';

        $query = Presensi::with('pegawai')
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($pegawaiId != 'all') {
            $query->where('pegawai_id', $pegawaiId);
        }

        $presensis = $query->orderBy('tanggal', 'desc')->get();
        $pegawais = Pegawai::all();

        // Statistik
        $totalHadir = $presensis->where('status', 'hadir')->count();
        $totalTerlambat = $presensis->filter(function($p) {
            return $p->is_late_check_in || $p->is_late_check_out;
        })->count();
        $totalIzin = $presensis->where('status', 'izin')->count();
        $totalSakit = $presensis->where('status', 'sakit')->count();
        $totalAlpha = $presensis->where('status', 'alpha')->count();

        return view('reports.index', compact(
            'presensis', 
            'pegawais', 
            'startDate', 
            'endDate', 
            'pegawaiId',
            'totalHadir',
            'totalTerlambat',
            'totalIzin',
            'totalSakit',
            'totalAlpha'
        ));
    }
}