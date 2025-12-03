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
                <a href="{{ route('web.productos') }}" class="nav-button">Todos los Productos</a>
                @foreach($categoriasValidas as $cat)
                    <a href="{{ route('web.productos', ['categoria' => $cat]) }}" class="nav-button">
                        {{ ucfirst(str_replace('-', ' ', $cat)) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="contenedor-productos">
        @if($categoria === 'todas' || $categoria === 'shampoos')
            @include('web.productos.shampoos')
        @endif

        @if($categoria === 'todas' || $categoria === 'acondicionadores')
            @include('web.productos.acondicionadores')
        @endif

        @if($categoria === 'todas' || $categoria === 'cremas')
            @include('web.productos.cremas')
        @endif

        @if($categoria === 'todas' || $categoria === 'tratamientos')
            @include('web.productos.tratamientos')
        @endif

        @if($categoria === 'todas' || $categoria === 'linea-natural')
            @include('web.productos.linea-natural')
        @endif

        @if($categoria === 'todas' || $categoria === 'linea-infantil')
            @include('web.productos.linea-infantil')
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush