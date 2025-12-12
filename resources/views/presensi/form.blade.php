<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slideIn {
            animation: slideIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('presensi.index') }}" class="flex items-center">
                        <i class="fas fa-clipboard-check text-3xl text-indigo-600 mr-3"></i>
                        <h1 class="text-2xl font-bold text-gray-800">Sistem Presensi</h1>
                    </a>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('presensi.index') }}" class="text-gray-600 hover:text-indigo-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-2xl p-8 animate-slideIn">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-100 rounded-full mb-4">
                    <i class="fas fa-user-check text-4xl text-indigo-600"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Form Presensi</h2>
                <p class="text-gray-600">Silakan isi data presensi Anda</p>
            </div>

            @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('presensi.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-user mr-2 text-indigo-600"></i>Pilih Pegawai
                    </label>
                    <select name="pegawai_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawais as $pegawai)
                        <option value="{{ $pegawai->id }}">{{ $pegawai->nama }} - {{ $pegawai->nip }} ({{ $pegawai->jabatan }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-clipboard-list mr-2 text-indigo-600"></i>Status Kehadiran
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="status" value="hadir" required class="peer sr-only">
                            <div class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 transition hover:shadow-md">
                                <div class="text-center">
                                    <i class="fas fa-check-circle text-3xl text-green-600 mb-2"></i>
                                    <p class="font-bold text-gray-700">Hadir</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="status" value="izin" class="peer sr-only">
                            <div class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-yellow-500 peer-checked:bg-yellow-50 transition hover:shadow-md">
                                <div class="text-center">
                                    <i class="fas fa-file-alt text-3xl text-yellow-600 mb-2"></i>
                                    <p class="font-bold text-gray-700">Izin</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="status" value="sakit" class="peer sr-only">
                            <div class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-orange-500 peer-checked:bg-orange-50 transition hover:shadow-md">
                                <div class="text-center">
                                    <i class="fas fa-procedures text-3xl text-orange-600 mb-2"></i>
                                    <p class="font-bold text-gray-700">Sakit</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="status" value="alpha" class="peer sr-only">
                            <div class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 transition hover:shadow-md">
                                <div class="text-center">
                                    <i class="fas fa-times-circle text-3xl text-red-600 mb-2"></i>
                                    <p class="font-bold text-gray-700">Alpha</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-comment mr-2 text-indigo-600"></i>Keterangan (Opsional)
                    </label>
                    <textarea name="keterangan" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none" placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 rounded-lg shadow-lg transition transform hover:scale-105">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Presensi
                    </button>
                </div>
            </form>

            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
                    <div>
                        <p class="text-sm text-blue-800 font-semibold mb-1">Informasi Penting:</p>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Presensi hanya dapat dilakukan sekali per hari</li>
                            <li>• Pilih status kehadiran dengan benar</li>
                            <li>• Tambahkan keterangan jika ada hal khusus</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white shadow-lg mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-600">© 2024 Sistem Presensi Pegawai. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>