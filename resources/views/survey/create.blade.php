@extends('layouts.admin')

@push('head')
    <style>
        #map { z-index: 1; min-height: 288px; }
        .pac-container {
            z-index: 9999 !important;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            margin-top: 4px;
            padding: 6px 0;
        }
        .pac-item {
            padding: 8px 14px;
            cursor: pointer;
            font-size: 13px;
        }
        .pac-item:hover {
            background-color: #f3f4f6;
        }
        .pac-item-query {
            font-size: 13px;
            color: #1a1a1a;
        }
    </style>
@endpush

@section('content')
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-xs text-on-secondary-fixed-variant mb-2 uppercase tracking-widest font-semibold">
            <span>Operasional</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Input Survey Baru</span>
        </nav>
        <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Entri Survei Baru</h2>
        <p class="text-on-surface-variant mt-1 font-body">Isi detail responden untuk memperbarui sistem manajemen data presisi.</p>
    </div>

    <div class="max-w-3xl bg-surface-container-lowest rounded-2xl shadow-xl shadow-surface-dim/20 border border-outline-variant/10 overflow-hidden">
        <form method="POST" action="{{ route('survey.store') }}">
            @csrf

            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Nama Responden</label>
                        <input type="text" name="nama_responden" value="{{ old('nama_responden') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg" 
                            placeholder="misal: Agus Ardiansyah">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Nomor Telepon</label>
                        <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg" 
                            placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Tipe Kriteria</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['Residensial' => 'home', 'Bisnis Kecil' => 'store', 'Perusahaan' => 'corporate_fare'] as $label => $icon)
                            <label class="cursor-pointer group">
                                <input type="radio" name="kriteria" value="{{ $label }}" class="hidden peer" required @checked(old('kriteria') === $label)>
                                <div class="border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary-container/10 p-4 rounded-xl text-center transition-all group-hover:bg-surface-container flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-on-surface-variant peer-checked:text-primary">{{ $icon }}</span>
                                    <span class="text-[11px] font-bold text-on-surface-variant peer-checked:text-primary uppercase tracking-tighter">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Hasil Survei</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 rounded-xl bg-surface-container-low border-2 border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-primary/40 has-[:checked]:bg-white">
                            <input type="radio" name="hasil_survey" value="berminat" class="text-primary focus:ring-primary w-5 h-5" required @checked(old('hasil_survey') === 'berminat')>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-emerald-700 leading-none">Berminat</span>
                                <span class="text-[10px] text-on-surface-variant uppercase tracking-tighter mt-1 block">Minat segera, siap untuk tindak lanjut</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 rounded-xl bg-surface-container-low border-2 border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-primary/40 has-[:checked]:bg-white">
                            <input type="radio" name="hasil_survey" value="pikir-pikir" class="text-primary focus:ring-primary w-5 h-5" @checked(old('hasil_survey') === 'pikir-pikir')>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-amber-700 leading-none">Pikir-pikir</span>
                                <span class="text-[10px] text-on-surface-variant uppercase tracking-tighter mt-1 block">Membutuhkan informasi lebih lanjut atau cek anggaran</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 rounded-xl bg-surface-container-low border-2 border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-primary/40 has-[:checked]:bg-white">
                            <input type="radio" name="hasil_survey" value="tidak berminat" class="text-primary focus:ring-primary w-5 h-5" @checked(old('hasil_survey') === 'tidak berminat')>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-slate-500 leading-none">Tidak berminat</span>
                                <span class="text-[10px] text-on-surface-variant uppercase tracking-tighter mt-1 block">Ditolak atau sedang tidak dalam cakupan</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Detailed Address Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-outline-variant/10">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg" 
                            placeholder="misal: Komodo">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Detail Alamat / Keterangan Rumah</label>
                        <textarea name="alamat_detail" rows="2" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg resize-none" 
                            placeholder="misal: RT 005 / RW 002, depan Warung Makan, pagar warna hijau">{{ old('alamat_detail') }}</textarea>
                    </div>
                </div>

                <!-- Map Location Selection Section -->
                <div class="space-y-4 pt-4 border-t border-outline-variant/10">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Pilih Lokasi di Peta (Google Maps)</label>
                        <span class="text-[10px] bg-primary/10 text-primary px-2.5 py-0.5 rounded-full font-bold uppercase tracking-tight">Ketik Alamat / Klik Peta</span>
                    </div>

                    <!-- Search Input above Map with Custom Nominatim Suggestions Fallback -->
                    <div class="relative" id="search-container">
                        <input type="text" id="map-search-input" 
                            class="w-full bg-surface-container-lowest border border-outline-variant/30 focus:ring-2 focus:ring-primary focus:border-primary transition-all p-3 pl-10 text-sm rounded-xl shadow-sm"
                            placeholder="Ketik nama jalan, hotel, atau wilayah (misal: Zasgo)..." autocomplete="off">
                        <span class="material-symbols-outlined absolute left-3 top-3.5 text-outline-variant text-lg">search</span>
                        
                        <!-- Free Search Spinner -->
                        <div id="search-spinner" class="hidden absolute right-3 top-3.5">
                            <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <!-- Dynamic Dropdown Suggestions -->
                        <div id="suggestions-dropdown" class="hidden absolute left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-outline-variant/30 z-[9999] overflow-hidden max-h-60 overflow-y-auto">
                            <!-- JS will inject items here -->
                        </div>
                    </div>

                    <div id="map" class="h-72 rounded-2xl border border-outline-variant/20 shadow-inner"></div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Latitude</label>
                            <input type="text" id="latitude" name="latitude" readonly value="{{ old('latitude') }}"
                                class="w-full bg-slate-100 border border-outline-variant/20 focus:outline-none p-2.5 text-xs rounded-lg text-slate-500 font-mono">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Longitude</label>
                            <input type="text" id="longitude" name="longitude" readonly value="{{ old('longitude') }}"
                                class="w-full bg-slate-100 border border-outline-variant/20 focus:outline-none p-2.5 text-xs rounded-lg text-slate-500 font-mono">
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-surface-container-low border-t border-outline-variant/10 flex gap-4 justify-end">
                <a href="{{ route('survey.index') }}" class="px-6 py-2 text-on-surface-variant font-bold text-sm hover:bg-surface-container-highest rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-gradient-to-br from-primary to-primary-dim px-10 py-2 rounded-lg text-white font-bold text-sm shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Kirim Data
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        window.initCreateMap = function() {
            const defaultLat = -8.4908;
            const defaultLng = 119.8824;
            
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            
            let initialLat = parseFloat(latitudeInput.value) || defaultLat;
            let initialLng = parseFloat(longitudeInput.value) || defaultLng;

            const mapCenter = { lat: initialLat, lng: initialLng };

            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: mapCenter,
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true
            });

            let marker;

            // Function to update inputs
            function updateLatLng(lat, lng) {
                latitudeInput.value = lat.toFixed(8);
                longitudeInput.value = lng.toFixed(8);
            }

            // If coordinates exist, create a marker
            if (latitudeInput.value && longitudeInput.value) {
                marker = new google.maps.Marker({
                    position: mapCenter,
                    map: map,
                    draggable: true
                });
                
                marker.addListener('dragend', function() {
                    const pos = marker.getPosition();
                    updateLatLng(pos.lat(), pos.lng());
                });
            }

            // Click event on map to place or move marker
            map.addListener('click', function(e) {
                const clickedLat = e.latLng.lat();
                const clickedLng = e.latLng.lng();

                updateLatLng(clickedLat, clickedLng);

                if (marker) {
                    marker.setPosition(e.latLng);
                } else {
                    marker = new google.maps.Marker({
                        position: e.latLng,
                        map: map,
                        draggable: true
                    });

                    marker.addListener('dragend', function() {
                        const pos = marker.getPosition();
                        updateLatLng(pos.lat(), pos.lng());
                    });
                }
            });

            // Custom Free Suggestion Dropdown logic using OpenStreetMap (Nominatim API)
            // This works 100% reliably even if the Google Maps API Key is missing or restricted!
            const searchInput = document.getElementById('map-search-input');
            const dropdown = document.getElementById('suggestions-dropdown');
            const spinner = document.getElementById('search-spinner');
            let debounceTimer;

            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value.trim();

                if (query.length < 3) {
                    dropdown.innerHTML = '';
                    dropdown.classList.add('hidden');
                    return;
                }

                spinner.classList.remove('hidden');

                debounceTimer = setTimeout(() => {
                    // Search localized to Labuan Bajo, NTT
                    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}+Labuan+Bajo&limit=5&addressdetails=1`;
                    
                    fetch(url, {
                        headers: {
                            'Accept-Language': 'id',
                            'User-Agent': 'TeldaLabuanBajo/1.0'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        spinner.classList.add('hidden');
                        dropdown.innerHTML = '';

                        if (data.length === 0) {
                            dropdown.innerHTML = `
                                <div class="p-4 text-xs text-on-surface-variant italic text-center">
                                    Tidak ada hasil ditemukan untuk "${query}"
                                </div>
                            `;
                            dropdown.classList.remove('hidden');
                            return;
                        }

                        data.forEach(item => {
                            const parts = item.display_name.split(',');
                            const name = parts[0];
                            const address = parts.slice(1).join(',').trim();
                            
                            const div = document.createElement('div');
                            div.className = 'p-3 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-0 transition-colors flex items-start gap-2.5';
                            div.innerHTML = `
                                <span class="material-symbols-outlined text-primary text-lg mt-0.5">location_on</span>
                                <div>
                                    <div class="text-sm font-semibold text-slate-800">${name}</div>
                                    <div class="text-[11px] text-slate-500 line-clamp-1">${address}</div>
                                </div>
                            `;

                            div.addEventListener('click', function() {
                                const lat = parseFloat(item.lat);
                                const lng = parseFloat(item.lon);

                                // Update Latitude & Longitude inputs
                                updateLatLng(lat, lng);

                                const pos = { lat: lat, lng: lng };
                                map.setCenter(pos);
                                map.setZoom(17);

                                if (marker) {
                                    marker.setPosition(pos);
                                } else {
                                    marker = new google.maps.Marker({
                                        position: pos,
                                        map: map,
                                        draggable: true
                                    });

                                    marker.addListener('dragend', function() {
                                        const p = marker.getPosition();
                                        updateLatLng(p.lat(), p.lng());
                                    });
                                }

                                // Auto-fill Kecamatan if available in response
                                const addressDetails = item.address;
                                if (addressDetails) {
                                    if (addressDetails.subdistrict) {
                                        document.querySelector('input[name="kecamatan"]').value = addressDetails.subdistrict;
                                    } else if (addressDetails.village) {
                                        document.querySelector('input[name="kecamatan"]').value = addressDetails.village;
                                    } else if (addressDetails.county) {
                                        document.querySelector('input[name="kecamatan"]').value = addressDetails.county;
                                    }
                                }

                                searchInput.value = item.display_name;
                                dropdown.classList.add('hidden');
                            });

                            dropdown.appendChild(div);
                        });

                        dropdown.classList.remove('hidden');
                    })
                    .catch(err => {
                        console.error(err);
                        spinner.classList.add('hidden');
                    });
                }, 400); // 400ms debounce
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!document.getElementById('search-container').contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            // Prevent form submit on Enter
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', '') }}&libraries=places&callback=initCreateMap" async defer></script>
@endpush