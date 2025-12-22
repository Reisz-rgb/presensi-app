<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <i class="fas fa-clipboard-check text-3xl text-indigo-600 mr-3"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Sistem Presensi</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600" id="current-time"></span>
                    <a href="/admin" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-user-shield mr-2"></i>Admin Panel
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alert Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded animate-fadeIn">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded animate-fadeIn">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Hero Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 animate-fadeIn">
            <div class="text-center">
                <h2 class="text-4xl font-bold text-gray-800 mb-2">Selamat Datang di Sistem Presensi</h2>
                <p class="text-gray-600 text-lg mb-6">Lakukan presensi kehadiran Anda dengan mudah dan cepat</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('presensi.form') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>Check In
                    </a>
                    <button onclick="document.getElementById('checkoutModal').classList.remove('hidden')" class="bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition transform hover:scale-105">
                        <i class="fas fa-sign-out-alt mr-2"></i>Check Out
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
            <!-- Total Pegawai -->
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-fadeIn">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Pegawai</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalPegawai }}</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i class="fas fa-users text-3xl text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Hadir -->
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.1s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Hadir Hari Ini</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $hadir }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-check-circle text-3xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Terlambat -->
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Terlambat</p>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $terlambat }}</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-full">
                        <i class="fas fa-clock text-3xl text-purple-600"></i>
                    </div>
                </div>
            </div>

            <!-- Izin -->
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Izin</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $izin }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full">
                        <i class="fas fa-file-alt text-3xl text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <!-- Sakit -->
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.4s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Sakit</p>
                        <p class="text-3xl font-bold text-orange-600 mt-2">{{ $sakit }}</p>
                    </div>
                    <div class="bg-orange-100 p-4 rounded-full">
                        <i class="fas fa-procedures text-3xl text-orange-600"></i>
                    </div>
                </div>
            </div>

            <!-- Alpha -->
            <div class="stat-card bg-white rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.5s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Alpha</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $alpha }}</p>
                    </div>
                    <div class="bg-red-100 p-4 rounded-full">
                        <i class="fas fa-times-circle text-3xl text-red-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 animate-fadeIn">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-clock text-2xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Jam Kerja</h3>
                </div>
                <p class="text-gray-600">Senin - Jumat: 08:00 - 17:00</p>
                <p class="text-gray-600">Sabtu: 08:00 - 12:00</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.1s">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-info-circle text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Ketentuan</h3>
                </div>
                <p class="text-gray-600">• Check-in maksimal: 08:15</p>
                <p class="text-gray-600">• Check-out minimal: 16:30</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 animate-fadeIn" style="animation-delay: 0.2s">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                        <i class="fas fa-phone text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Bantuan</h3>
                </div>
                <p class="text-gray-600">Email: hr@perusahaan.com</p>
                <p class="text-gray-600">Telp: (021) 1234-5678</p>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Check Out</h3>
                <button onclick="document.getElementById('checkoutModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <form action="{{ route('presensi.checkout') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Pegawai</label>
                    <select name="pegawai_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach(\App\Models\Pegawai::all() as $pegawai)
                        <option value="{{ $pegawai->id }}">{{ $pegawai->nama }} ({{ $pegawai->nip }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-bold py-3 rounded-lg transition">
                    <i class="fas fa-sign-out-alt mr-2"></i>Konfirmasi Check Out
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-gray-600">© 2024 Sistem Presensi Pegawai. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('current-time').textContent = now.toLocaleDateString('id-ID', options);
        }
        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>
</html>