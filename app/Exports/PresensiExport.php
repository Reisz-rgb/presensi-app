<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class PresensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $pegawaiId;

    public function __construct($startDate = null, $endDate = null, $pegawaiId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->pegawaiId = $pegawaiId;
    }

    public function collection()
    {
        $query = Presensi::with('pegawai');

        if ($this->startDate) {
            $query->where('tanggal', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->where('tanggal', '<=', $this->endDate);
        }

        if ($this->pegawaiId && $this->pegawaiId != 'all') {
            $query->where('pegawai_id', $this->pegawaiId);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIP',
            'Nama Pegawai',
            'Tanggal',
            'Jam Masuk',
            'Jam Keluar',
            'Status',
            'Terlambat Check-In',
            'Terlambat Check-Out',
            'Total Keterlambatan (Menit)',
            'Status Keterlambatan',
            'Keterangan',
            'Latitude',
            'Longitude',
        ];
    }

    public function map($presensi): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $presensi->pegawai->nip ?? '-',
            $presensi->pegawai->nama ?? '-',
            Carbon::parse($presensi->tanggal)->format('d/m/Y'),
            $presensi->jam_masuk ? Carbon::parse($presensi->jam_masuk)->format('H:i:s') : '-',
            $presensi->jam_keluar ? Carbon::parse($presensi->jam_keluar)->format('H:i:s') : '-',
            ucfirst($presensi->status),
            $presensi->is_late_check_in ? 'Ya' : 'Tidak',
            $presensi->is_late_check_out ? 'Ya' : 'Tidak',
            $presensi->late_duration_minutes ?? 0,
            $presensi->late_status,
            $presensi->keterangan ?? '-',
            $presensi->latitude ?? '-',
            $presensi->longitude ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF']
                ]
            ],
        ];
    }
}