{{-- resources/views/partials/_menu-item.blade.php --}}

@php
    // Mendefinisikan kelas CSS secara dinamis
    $liClass = '';


    if ($menu->children->isNotEmpty()) {
        $liClass = ($menu->parent == 0) ? "nav-item" : "submenu";
    } elseif ($menu->parent == 0) {
        $liClass = "nav-item";
    }

    $ulClass = ($menu->parent == 0) ? 'nav nav-collapse' : 'nav nav-collapse subnav';
@endphp

<li class="{{ $liClass }}" id="{{ substr($menu->path, 1) }}">

    @if ($menu->children->isNotEmpty())
        {{-- RENDER SEBAGAI DROPDOWN --}}
        <a data-bs-toggle="collapse" href="#menu-{{ $menu->id }}">
            @if ($menu->parent == 0)
                <i class="{{ $menu->icon }}"></i>
                <p>{{ $menu->name }}</p>
            @else
                <span class="sub-item">{{ $menu->name }}</span>
            @endif
            <span class="caret"></span>
        </a>
        <div class="collapse" id="menu-{{ $menu->id }}">
            <ul class="{{ $ulClass }}">
                @foreach ($menu->children as $child)
                    @include('layouts.sidebar_item', ['menu' => $child])
                @endforeach
            </ul>
        </div>

    @else
        {{-- RENDER SEBAGAI LINK BIASA --}}
        <a href="{{ $menu->path ? url($menu->path) : '#' }}">
            @if ($menu->parent == 0)
                <i class="{{ $menu->icon }}"></i>
                <p>{{ $menu->name }}</p>
            @else
                <span class="sub-item">{{ $menu->name }}</span>
            @endif
        </a>
    @endif

</li>
