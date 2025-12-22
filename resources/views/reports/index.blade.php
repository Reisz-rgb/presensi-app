<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Laporan Presensi</h1>
                        <p class="text-gray-600 mt-1">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                    </div>
                    <a href="/admin" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Admin
                    </a>
                </div>

                <!-- Filter Form -->
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pegawai</label>
                        <select name="pegawai_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="all">Semua Pegawai</option>
                            @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}" {{ $pegawaiId == $pegawai->id ? 'selected' : '' }}>
                                {{ $pegawai->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-3xl text-green-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Hadir</p>
                            <p class="text-2xl font-bold text-green-700">{{ $totalHadir }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 border-l-4 border-purple-500 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-3xl text-purple-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Terlambat</p>
                            <p class="text-2xl font-bold text-purple-700">{{ $totalTerlambat }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-file-alt text-3xl text-yellow-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Izin</p>
                            <p class="text-2xl font-bold text-yellow-700">{{ $totalIzin }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-50 border-l-4 border-orange-500 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-procedures text-3xl text-orange-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Sakit</p>
                            <p class="text-2xl font-bold text-orange-700">{{ $totalSakit }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                    <div class="flex items-center">
                        <i class="fas fa-times-circle text-3xl text-red-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Alpha</p>
                            <p class="text-2xl font-bold text-red-700">{{ $totalAlpha }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">NIP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Check In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Check Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Keterlambatan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($presensis as $index => $presensi)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presensi->pegawai->nip }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $presensi->pegawai->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($presensi->jam_masuk)
                                        <span class="flex items-center {{ $presensi->is_late_check_in ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                            {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}
                                            @if($presensi->is_late_check_in)
                                                <i class="fas fa-exclamation-circle ml-1"></i>
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($presensi->jam_keluar)
                                        <span class="flex items-center {{ $presensi->is_late_check_out ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                            {{ \Carbon\Carbon::parse($presensi->jam_keluar)->format('H:i') }}
                                            @if($presensi->is_late_check_out)
                                                <i class="fas fa-exclamation-circle ml-1"></i>
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $presensi->status == 'hadir' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $presensi->status == 'izin' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $presensi->status == 'sakit' ? 'bg-orange-100 text-orange-800' : '' }}
                                        {{ $presensi->status == 'alpha' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($presensi->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($presensi->is_late_check_in || $presensi->is_late_check_out)
                                        <div class="text-red-600 font-semibold">
                                            @if($presensi->is_late_check_in)
                                                <div><i class="fas fa-arrow-right mr-1"></i>Terlambat Masuk</div>
                                            @endif
                                            @if($presensi->is_late_check_out)
                                                <div><i class="fas fa-arrow-left mr-1"></i>Pulang Cepat</div>
                                            @endif
                                            @if($presensi->late_duration_minutes)
                                                <div class="text-xs text-gray-600 mt-1">{{ $presensi->late_duration_minutes }} menit</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-green-600 font-semibold">
                                            <i class="fas fa-check mr-1"></i>Tepat Waktu
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data presensi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 text-xl mr-3 mt-1"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-2">Keterangan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Terlambat Masuk:</strong> Check-in LEWAT dari jam 08:00</li>
                            <li><strong>Pulang Cepat:</strong> Check-out KURANG DARI atau SAMA DENGAN jam 16:00</li>
                            <li>Jam kerja: 08:00 - 16:00 (lebih dari 8 jam)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>