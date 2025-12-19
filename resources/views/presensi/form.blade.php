<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Leaflet CSS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slideIn {
            animation: slideIn 0.5s ease-out;
        }
        #map {
            height: 300px;
            border-radius: 0.5rem;
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
                            <input type="radio" name="status" value="hadir" required class="peer sr-only" onchange="toggleTimePickerVisibility()">
                            <div class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 transition hover:shadow-md">
                                <div class="text-center">
                                    <i class="fas fa-check-circle text-3xl text-green-600 mb-2"></i>
                                    <p class="font-bold text-gray-700">Hadir</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="status" value="izin" class="peer sr-only" onchange="toggleTimePickerVisibility()">
                            <div class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-yellow-500 peer-checked:bg-yellow-50 transition hover:shadow-md">
                                <div class="text-center">
                                    <i class="fas fa-file-alt text-3xl text-yellow-600 mb-2"></i>
                                    <p class="font-bold text-gray-700">Izin</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="status" value="sakit" class="peer sr-only" onchange="toggleTimePickerVisibility()">
                            <div class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-orange-500 peer-checked:bg-orange-50 transition hover:shadow-md">
                                <div class="text-center">
                                    <i class="fas fa-procedures text-3xl text-orange-600 mb-2"></i>
                                    <p class="font-bold text-gray-700">Sakit</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative">
                            <input type="radio" name="status" value="alpha" class="peer sr-only" onchange="toggleTimePickerVisibility()">
                            <div class="w-full p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 transition hover:shadow-md">
                                <div class="text-center">
                                    <i class="fas fa-times-circle text-3xl text-red-600 mb-2"></i>
                                    <p class="font-bold text-gray-700">Alpha</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Time Picker (hanya muncul jika status Hadir) -->
                <div id="timePickerSection" style="display: none;">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-clock mr-2 text-indigo-600"></i>Jam Masuk (Opsional)
                    </label>
                    <input type="text" id="timePicker" name="jam_masuk_manual" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                           placeholder="Pilih waktu atau gunakan waktu saat ini">
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Kosongkan untuk menggunakan waktu saat ini
                    </p>
                </div>

                <!-- Location Picker -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>Lokasi Presensi
                    </label>
                    <div class="space-y-3">
                        <button type="button" onclick="getLocation()" 
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg transition">
                            <i class="fas fa-location-crosshairs mr-2"></i>Dapatkan Lokasi Saat Ini
                        </button>
                        
                        <div id="map" class="shadow-lg"></div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Latitude</label>
                                <input type="text" id="latitude" name="latitude" readonly
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50"
                                       placeholder="-">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Longitude</label>
                                <input type="text" id="longitude" name="longitude" readonly
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50"
                                       placeholder="-">
                            </div>
                        </div>
                        
                        <div id="locationStatus" class="text-sm text-gray-500 text-center"></div>
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
                            <li>• Aktifkan lokasi untuk mencatat koordinat</li>
                            <li>• Pilih status kehadiran dengan benar</li>
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

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Initialize Time Picker
        const timePicker = flatpickr("#timePicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i:S",
            time_24hr: true,
            defaultHour: new Date().getHours(),
            defaultMinute: new Date().getMinutes()
        });

        // Toggle Time Picker visibility
        function toggleTimePickerVisibility() {
            const status = document.querySelector('input[name="status"]:checked').value;
            const timePickerSection = document.getElementById('timePickerSection');
            
            if (status === 'hadir') {
                timePickerSection.style.display = 'block';
            } else {
                timePickerSection.style.display = 'none';
            }
        }

        // Initialize Map
        let map = L.map('map').setView([-6.9666204, 110.4166495], 13); // Default: Semarang
        let marker;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Get current location
        function getLocation() {
            const statusDiv = document.getElementById('locationStatus');
            
            if (!navigator.geolocation) {
                statusDiv.textContent = 'Geolocation tidak didukung oleh browser Anda';
                statusDiv.className = 'text-sm text-red-500 text-center';
                return;
            }

            statusDiv.textContent = 'Mengambil lokasi...';
            statusDiv.className = 'text-sm text-blue-500 text-center';

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    updateLocation(lat, lng);
                    statusDiv.textContent = '✓ Lokasi berhasil didapatkan';
                    statusDiv.className = 'text-sm text-green-600 text-center font-semibold';
                },
                (error) => {
                    statusDiv.textContent = 'Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.';
                    statusDiv.className = 'text-sm text-red-500 text-center';
                }
            );
        }

        // Update location on map
        function updateLocation(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
            
            map.setView([lat, lng], 16);
            
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
            
            marker.bindPopup('<b>Lokasi Anda</b>').openPopup();
        }

        // Allow map click to set location
        map.on('click', function(e) {
            updateLocation(e.latlng.lat, e.latlng.lng);
        });

        //Auto-get location on page load (optional)
        getLocation();
    </script>
</body>
</html>