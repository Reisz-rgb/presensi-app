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
        $terlambat = Presensi::where('tanggal', $today)
            ->where(function($query) {
                $query->where('is_late_check_in', true)
                      ->orWhere('is_late_check_out', true);
            })->count();

        return view('presensi.index', compact('totalPegawai', 'hadir', 'izin', 'sakit', 'alpha', 'terlambat'));
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
            'keterangan' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'jam_masuk_manual' => 'nullable|date_format:H:i:s'
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
        $presensi->latitude = $request->latitude;
        $presensi->longitude = $request->longitude;
        
        if ($request->status == 'hadir') {
            // Gunakan jam manual jika ada, jika tidak gunakan waktu saat ini
            $presensi->jam_masuk = $request->jam_masuk_manual 
                ? $request->jam_masuk_manual 
                : Carbon::now()->format('H:i:s');
            
            // Cek keterlambatan check-in
            $presensi->checkLateCheckIn();
        }
        
        $presensi->save();

        // Buat pesan dengan info keterlambatan
        $message = 'Presensi berhasil disimpan!';
        if ($presensi->is_late_check_in) {
            $message .= ' (Terlambat check-in ' . $presensi->late_duration_minutes . ' menit)';
        }

        return redirect()->route('presensi.index')->with('success', $message);
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
        
        // Cek keterlambatan check-out
        $presensi->checkLateCheckOut();
        $presensi->save();

        // Buat pesan dengan info keterlambatan
        $message = 'Check-out berhasil!';
        if ($presensi->is_late_check_out) {
            $lateMinutes = Carbon::parse($presensi->jam_keluar)->diffInMinutes(Carbon::parse(Presensi::CHECK_OUT_TIME));
            $message .= ' (Pulang terlalu cepat ' . $lateMinutes . ' menit)';
        }

        return redirect()->route('presensi.index')->with('success', $message);
    }
}