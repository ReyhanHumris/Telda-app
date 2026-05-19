<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('status') || session('success'))
            @php 
                $msg = session('status') ?? session('success'); 
                $msgLower = strtolower($msg);
                
                $background = '#ffffff';
                $iconHtml = '<div style="width:40px;height:40px;border-radius:50%;background:#e3e9ec;display:flex;align-items:center;justify-content:center;"><span class="material-symbols-outlined" style="color:#185eb0">info</span></div>';

                if (str_contains($msgLower, 'dihapus') || str_contains($msgLower, 'sampah') || str_contains($msgLower, 'permanen')) {
                    $background = '#fff7f6'; 
                    $iconHtml = '<div style="width:40px;height:40px;border-radius:50%;background:#ffe4e1;display:flex;align-items:center;justify-content:center;"><span class="material-symbols-outlined" style="color:#9f403d">delete_sweep</span></div>';
                } elseif (str_contains($msgLower, 'disimpan') || str_contains($msgLower, 'ditambahkan') || str_contains($msgLower, 'baru')) {
                    $background = '#f2faff';
                    $iconHtml = '<div style="width:40px;height:40px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;"><span class="material-symbols-outlined" style="color:#16a34a">check_circle</span></div>';
                }
            @endphp
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: '{{ $background }}',
                padding: '0',
                html: `
                    <div style="display:flex;align-items:center;gap:16px;padding:16px;">
                        {!! $iconHtml !!}
                        <div style="text-align:left;">
                            <h4 style="margin:0;font-size:14px;font-weight:bold;color:#2b3437">Pemberitahuan Sistem</h4>
                            <p style="margin:4px 0 0 0;font-size:12px;color:#586064">{{ addslashes($msg) }}</p>
                        </div>
                    </div>
                `,
                customClass: {
                    popup: 'rounded-xl shadow-xl border border-outline-variant/20 !w-auto !max-w-md',
                }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#185eb0'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                html: '<ul style="text-align: left; list-style-type: disc; padding-left: 20px;">' +
                    @foreach ($errors->all() as $error)
                        '<li>{{ addslashes($error) }}</li>' +
                    @endforeach
                '</ul>',
                confirmButtonColor: '#185eb0'
            });
        @endif
    });
</script>
