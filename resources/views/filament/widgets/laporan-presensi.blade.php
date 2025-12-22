<x-filament::widget>
    <x-filament::card>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold">Laporan Presensi</h2>
            </div>

            <form action="{{ route('presensi.export') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Pilih Pegawai -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Pegawai</label>
                        <select name="pegawai_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="all">Semua Pegawai</option>
                            @foreach(\App\Models\Pegawai::all() as $pegawai)
                            <option value="{{ $pegawai->id }}">{{ $pegawai->nama }} ({{ $pegawai->nip }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ date('Y-m-01') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <!-- Tanggal Akhir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ date('Y-m-d') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-success-600 border border-transparent rounded-lg font-semibold text-white hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-success-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export Excel
                    </button>
                    
                    <a href="{{ route('presensi.report') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Lihat Laporan
                    </a>
                </div>
            </form>

            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informasi Laporan</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Laporan akan mencakup data check-in, check-out, dan status keterlambatan</li>
                                <li>Pilih "Semua Pegawai" untuk export data semua pegawai</li>
                                <li>Keterlambatan check-in: Masuk LEWAT dari jam 08:00</li>
                                <li>Keterlambatan check-out: Pulang KURANG DARI atau SAMA DENGAN jam 16:00</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>