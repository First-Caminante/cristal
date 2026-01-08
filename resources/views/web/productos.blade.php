@extends('web.layouts.app')

@section('title', 'Productos - Industrias Cristal')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/styleprod.css') }}">
@endsection

@section('content')
    <!-- Hero de productos -->
    <section class="hero-productos">
        <div class="hero-content">
            <h1>Nuestros Productos</h1>
            <p class="lead">Descubre nuestra línea completa de cosméticos de calidad premium</p>
        </div>
    </section>

    <!-- Navegación rápida -->
    <div class="quick-nav-wrapper">
        <div class="quick-nav">
            <div class="quick-nav-buttons">
                <a href="{{ route('web.productos') }}" class="nav-button {{ $categoria === 'todas' ? 'active' : '' }}">Todos
                    los Productos</a>
                @foreach($categorias as $cat)
                    <a href="{{ route('web.productos', ['categoria' => $cat->slug]) }}"
                        class="nav-button {{ $categoria === $cat->slug ? 'active' : '' }}">
                        {{ $cat->nombre }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="contenedor-productos">
        <div class="products-grid">
            @forelse($productos as $producto)
                <div class="product-card">
                    <div class="product-icon">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                class="product-image">
                        @else
                            <div class="no-img-placeholder flex items-center justify-center bg-gray-100 rounded-lg w-full h-full">
                                <span class="text-gray-400">Sin Imagen</span>
                            </div>
                        @endif
                    </div>
                    <div class="product-info">
                        <h3 class="mt-4">{{ $producto->nombre }}</h3>
                        @if($producto->descripcion)
                            <p class="description">{{ $producto->descripcion }}</p>
                        @endif

                        @if($producto->caracteristicas && count($producto->caracteristicas) > 0)
                            <div class="product-features mt-4">
                                @foreach($producto->caracteristicas as $caract)
                                    <span class="feature-badge">{{ $caract }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <p class="text-gray-500 text-xl font-medium">No se encontraron productos en esta categoría.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush