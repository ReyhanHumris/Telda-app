@php
    $sizeClass = match($size ?? 'md') {
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-14 h-14 text-lg',
        default => 'w-10 h-10 text-sm',
    };
    $initials = strtoupper(substr($user->nama_lengkap ?? 'U', 0, 2));
@endphp

@if ($user && $user->foto)
    <img src="{{ $user->foto_url }}" alt="Avatar" class="{{ $sizeClass }} rounded-full object-cover {{ $class ?? '' }}">
@else
    <div class="rounded-full bg-primary-container flex items-center justify-center text-primary font-bold {{ $sizeClass }} {{ $class ?? '' }}">
        {{ $initials }}
    </div>
@endif
