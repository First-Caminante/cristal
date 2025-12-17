@extends('web.layouts.app')

@section('title', 'Inicio - Industrias Cristal')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/stylehome.css') }}">
@endsection

@section('content')
    <!-- DEBUG: {{ json_encode($content) }} -->
    <!-- HERO SECTION -->
    <section id="inicio" class="hero">
        <div class="hero-background"></div>
        <div class="hero-container">
            <div class="hero-content">
                <h1>{{ $content['hero']['title'] }}</h1>
                <p>{{ $content['hero']['text'] }}</p>
                <a href="{{ route('web.productos') }}" class="cta-button">Conoce Nuestros Productos</a>
            </div>
            <div class="hero-image">
                <div class="hero-image-wrapper">
                    <img src="{{ asset('storage/' . $content['hero']['image']) }}" alt="Productos Cristal">
                    <div class="hero-image-decoration"></div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <span></span>
        </div>
    </section>

    @if($promocion)
        <!-- SECCIÓN PROMOCIÓN DEL MES -->
        <section class="promo-month">
            <div class="promo-container">
                <div class="promo-content">
                    <span class="promo-badge">PROMOCIÓN DEL MES</span>
                    <h2>{{ $promocion->titulo }}</h2>
                    <p class="promo-description">
                        {{ $promocion->descripcion }}
                    </p>
                    <div class="promo-details">
                        <div class="promo-detail">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path
                                    d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                    stroke-width="2" />
                                <path d="M12 6V12L16 14" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span>Válido hasta {{ \Carbon\Carbon::parse($promocion->fecha_fin)->format('d/m/Y') }}</span>
                        </div>
                        <div class="promo-detail">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path
                                    d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Para todos los clientes</span>
                        </div>
                        <div class="promo-detail">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M9 11L12 14L22 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>Envío gratis en compras +150 Bs</span>
                        </div>
                    </div>
                    <a href="{{ route('web.productos') }}" class="promo-button">Ver Productos en Oferta</a>
                </div>
                <div class="promo-image">
                    <div class="promo-image-wrapper">
                        @if($promocion->fotos->isNotEmpty())
                            <img src="{{ asset('storage/' . $promocion->fotos->first()->ruta_foto) }}"
                                alt="{{ $promocion->titulo }}">
                        @else
                            <img src="{{ asset('assets/images/home/promo_mes.png') }}" alt="Promoción del Mes">
                        @endif

                        @if($promocion->precio)
                            <div class="promo-discount-badge">
                                <span class="discount-number">{{ $promocion->precio }}</span>
                                <span class="discount-text">Bs</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- SECCIÓN PRODUCTO ESTRELLA -->
    <section class="featured-product">
        <div class="featured-container">
            <div class="featured-image">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $content['featured']['image']) }}" alt="Producto Destacado">
                    <div class="image-decoration"></div>
                </div>
            </div>
            <div class="featured-content">
                <span class="featured-tag">PRODUCTO ESTRELLA</span>
                <h2>{{ $content['featured']['title'] }}</h2>
                <p class="featured-description">
                    {{ $content['featured']['description'] }}
                </p>
                <ul class="featured-benefits">
                    @foreach($content['featured']['benefits'] as $benefit)
                        <li>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M7 10L9 12L13 8M19 10C19 14.9706 14.9706 19 10 19C5.02944 19 1 14.9706 1 10C1 5.02944 5.02944 1 10 1C14.9706 1 19 5.02944 19 10Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>
                <!-- Botón eliminado por solicitud -->
            </div>
        </div>
    </section>

    <!-- SECCIÓN TESTIMONIOS DE CLIENTES -->
    <section class="testimonios-section">
        <div class="testimonios-header">
            <h2>Lo Que Dicen Nuestros Clientes</h2>
            <p>Experiencias reales de personas que confían en nuestros productos</p>
        </div>

        <div class="testimonios-container">
            @forelse($testimonios as $testimonio)
                <div class="testimonio-card">
                    <div class="testimonio-header">
                        <div class="testimonio-avatar">
                            {{ strtoupper(substr($testimonio->nombre, 0, 1)) }}
                        </div>
                        <div class="testimonio-info">
                            <h4>{{ $testimonio->nombre }}</h4>
                            <div class="testimonio-meta">
                                <span class="testimonio-fuente">
                                    @if($testimonio->fuente == 'Facebook')
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                        </svg>
                                    @elseif($testimonio->fuente == 'Instagram')
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                            <path
                                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                                        </svg>
                                    @else
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path
                                                d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                                                stroke-width="2" />
                                            <path
                                                d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                                                stroke-width="2" />
                                        </svg>
                                    @endif
                                    {{ $testimonio->fuente }}
                                </span>
                                <span class="testimonio-fecha">
                                    {{ $testimonio->fecha_publicacion->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonio-stars">
                        ⭐⭐⭐⭐⭐
                    </div>
                    <p class="testimonio-comentario">
                        "{{ $testimonio->comentario }}"
                    </p>
                </div>
            @empty
                <div class="no-testimonios">
                    <p>Próximamente verás aquí las experiencias de nuestros clientes.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection