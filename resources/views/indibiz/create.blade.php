@extends('layouts.admin')

@push('head')
    <style>
        #map { z-index: 1; min-height: 288px; }
    </style>
@endpush

@section('content')
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-xs text-on-secondary-fixed-variant mb-2 uppercase tracking-widest font-semibold">
            <span>Manajemen</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Input Data Indibiz</span>
        </nav>
        <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Tambah Data Pelanggan</h2>
        <p class="text-on-surface-variant mt-1 font-body">Daftarkan entitas bisnis baru ke dalam ekosistem Indibiz Labuan Bajo.</p>
    </div>

    <div class="max-w-3xl bg-surface-container-lowest rounded-2xl shadow-xl shadow-surface-dim/20 border border-outline-variant/10 overflow-hidden">
        <form method="POST" action="{{ route('indibiz.store') }}">
            @csrf

            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Nama Perusahaan / UMKM</label>
                        <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg" 
                            placeholder="misal: PT Maju Jaya">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Alamat Perusahaan</label>
                        <input type="text" name="alamat_perusahaan" value="{{ old('alamat_perusahaan') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg" 
                            placeholder="Jl. Soekarno Hatta, Labuan Bajo">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Jenis Layanan Indibiz</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @php
                            $services = [
                                'Connectivity' => 'router',
                                'Digital Ads' => 'ads_click',
                                'SaaS' => 'cloud_done',
                                'Bundling' => 'Inventory_2'
                            ];
                        @endphp
                        @foreach($services as $label => $icon)
                            <label class="cursor-pointer group">
                                <input type="radio" name="jenis_layanan" value="{{ $label }}" class="hidden peer" required @checked(old('jenis_layanan') === $label)>
                                <div class="border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary-container/10 p-4 rounded-xl text-center transition-all group-hover:bg-surface-container flex flex-col items-center gap-2 h-full justify-center">
                                    <span class="material-symbols-outlined text-on-surface-variant peer-checked:text-primary">{{ $icon }}</span>
                                    <span class="text-[10px] font-bold text-on-surface-variant peer-checked:text-primary uppercase tracking-tighter">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Status Operasional</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="flex items-center p-4 rounded-xl bg-surface-container-low border-2 border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-primary/40 has-[:checked]:bg-white">
                            <input type="radio" name="status_langganan" value="aktif" class="text-primary focus:ring-primary w-5 h-5" required @checked(old('status_langganan') === 'aktif')>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-primary leading-none">Aktif</span>
                                <span class="text-[10px] text-on-surface-variant uppercase tracking-tighter mt-1 block">Layanan sedang berjalan normal</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 rounded-xl bg-surface-container-low border-2 border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-error/40 has-[:checked]:bg-white">
                            <input type="radio" name="status_langganan" value="nonaktif" class="text-error focus:ring-error w-5 h-5" @checked(old('status_langganan') === 'nonaktif')>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-error leading-none">Nonaktif</span>
                                <span class="text-[10px] text-on-surface-variant uppercase tracking-tighter mt-1 block">Layanan dihentikan atau ditangguhkan</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Map Location Selection Section -->
                <div class="space-y-3 pt-4 border-t border-outline-variant/10">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Pilih Lokasi Perusahaan di Peta (Google Maps / OpenStreetMap)</label>
                        <span class="text-[10px] bg-primary/10 text-primary px-2.5 py-0.5 rounded-full font-bold uppercase tracking-tight">Klik Peta untuk Pin</span>
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
                <a href="{{ route('indibiz.index') }}" class="px-6 py-2 text-on-surface-variant font-bold text-sm hover:bg-surface-container-highest rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-gradient-to-br from-primary to-primary-dim px-10 py-2 rounded-lg text-white font-bold text-sm shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Simpan Data Indibiz
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

            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: { lat: initialLat, lng: initialLng },
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true
            });

            let marker;

            // If coordinates exist, create a marker
            if (latitudeInput.value && longitudeInput.value) {
                marker = new google.maps.Marker({
                    position: { lat: initialLat, lng: initialLng },
                    map: map,
                    draggable: true
                });
                
                marker.addListener('dragend', function() {
                    const pos = marker.getPosition();
                    latitudeInput.value = pos.lat().toFixed(8);
                    longitudeInput.value = pos.lng().toFixed(8);
                });
            }

            // Click event on map to place or move marker
            map.addListener('click', function(e) {
                const clickedLat = e.latLng.lat().toFixed(8);
                const clickedLng = e.latLng.lng().toFixed(8);

                latitudeInput.value = clickedLat;
                longitudeInput.value = clickedLng;

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
                        latitudeInput.value = pos.lat().toFixed(8);
                        longitudeInput.value = pos.lng().toFixed(8);
                    });
                }
            });
        };
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', '') }}&callback=initCreateMap" async defer></script>
@endpush