@if (session('status'))
    <div class="mb-6 rounded-xl border border-primary/20 bg-primary/5 px-4 py-3 text-primary-dim">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-xl border border-error/20 bg-error/5 px-4 py-3 text-error">
        <div class="font-semibold mb-1">Terjadi kesalahan:</div>
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

