<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
        'latitude',
        'longitude',
        'is_late_check_in',
        'is_late_check_out',
        'late_duration_minutes'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_late_check_in' => 'boolean',
        'is_late_check_out' => 'boolean',
    ];

    // Jam kerja standard
    const CHECK_IN_TIME = '08:00:00';
    const CHECK_OUT_TIME = '16:00:00';

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Method untuk cek keterlambatan check-in
    public function checkLateCheckIn()
    {
        if (!$this->jam_masuk) return;

        $jamMasuk = Carbon::parse($this->jam_masuk);
        $batasCheckIn = Carbon::parse(self::CHECK_IN_TIME);

        // Terlambat jika LEWAT jam 8 (jam_masuk > 08:00:00)
        if ($jamMasuk->gt($batasCheckIn)) {
            $this->is_late_check_in = true;
            $lateDuration = $jamMasuk->diffInMinutes($batasCheckIn);
            $this->late_duration_minutes = ($this->late_duration_minutes ?? 0) + $lateDuration;
        } else {
            $this->is_late_check_in = false;
        }
    }

    // Method untuk cek keterlambatan check-out
    public function checkLateCheckOut()
    {
        if (!$this->jam_keluar) return;

        $jamKeluar = Carbon::parse($this->jam_keluar);
        $batasCheckOut = Carbon::parse(self::CHECK_OUT_TIME);

        // Terlambat jika KURANG DARI atau SAMA DENGAN jam 16 (jam_keluar <= 16:00:00)
        if ($jamKeluar->lte($batasCheckOut)) {
            $this->is_late_check_out = true;
            $earlyDuration = $batasCheckOut->diffInMinutes($jamKeluar);
            $this->late_duration_minutes = ($this->late_duration_minutes ?? 0) + $earlyDuration;
        } else {
            $this->is_late_check_out = false;
        }
    }

    // Accessor untuk status keterlambatan
    public function getLateStatusAttribute()
    {
        if ($this->is_late_check_in && $this->is_late_check_out) {
            return 'Terlambat Check-In & Check-Out';
        } elseif ($this->is_late_check_in) {
            return 'Terlambat Check-In';
        } elseif ($this->is_late_check_out) {
            return 'Terlambat Check-Out';
        }
        return 'Tepat Waktu';
    }
}