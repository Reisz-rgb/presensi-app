<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $totalPegawai = Pegawai::count();
        $hadir = Presensi::where('tanggal', $today)->where('status', 'hadir')->count();
        $izin = Presensi::where('tanggal', $today)->where('status', 'izin')->count();
        $sakit = Presensi::where('tanggal', $today)->where('status', 'sakit')->count();
        $alpha = $totalPegawai - ($hadir + $izin + $sakit);

        return view('presensi.index', compact('totalPegawai', 'hadir', 'izin', 'sakit', 'alpha'));
    }

    public function form()
    {
        $pegawais = Pegawai::all();
        return view('presensi.form', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string'
        ]);

        $today = Carbon::today();
        
        // Cek apakah sudah presensi hari ini
        $existing = Presensi::where('pegawai_id', $request->pegawai_id)
            ->where('tanggal', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melakukan presensi hari ini!');
        }

        $presensi = new Presensi();
        $presensi->pegawai_id = $request->pegawai_id;
        $presensi->tanggal = $today;
        $presensi->status = $request->status;
        $presensi->keterangan = $request->keterangan;
        
        if ($request->status == 'hadir') {
            $presensi->jam_masuk = Carbon::now()->format('H:i:s');
        }
        
        $presensi->save();

        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil disimpan!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id'
        ]);

        $today = Carbon::today();
        
        $presensi = Presensi::where('pegawai_id', $request->pegawai_id)
            ->where('tanggal', $today)
            ->where('status', 'hadir')
            ->whereNull('jam_keluar')
            ->first();

        if (!$presensi) {
            return back()->with('error', 'Anda belum melakukan check-in hari ini!');
        }

        $presensi->jam_keluar = Carbon::now()->format('H:i:s');
        $presensi->save();

        return redirect()->route('presensi.index')->with('success', 'Check-out berhasil!');
    }
}