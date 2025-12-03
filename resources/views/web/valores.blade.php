@extends('web.layouts.app')

@section('title', 'Nuestros Valores - Industrias Cristal')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/stylevalores.css') }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="valores-hero">
        <div class="valores-hero-content">
            <h1>Nuestros Valores</h1>
            <p>Los pilares fundamentales que guían cada paso de nuestro camino hacia la excelencia</p>
        </div>
    </section>

    <!-- Sección de Valores -->
    <section class="valores-section">
        <div class="valores-container">
            <!-- Valor 1: Calidad -->
            <div class="valor-card">
                <div class="valor-image">
                    <img src="{{ asset('assets/images/valores/calidad.jpg') }}" alt="Calidad Premium">
                    <div class="valor-overlay">
                        <span class="valor-number">01</span>
                    </div>
                </div>
                <div class="valor-content">
                    <h3>Calidad Premium</h3>
                    <p>
                        Nos comprometemos a utilizar solo los mejores ingredientes y procesos de fabricación
                        para asegurar que cada producto cumpla con los más altos estándares internacionales.
                    </p>
                </div>
            </div>

            <!-- Valor 2: Innovación -->
            <div class="valor-card">
                <div class="valor-image">
                    <img src="{{ asset('assets/images/valores/innovacion.jpg') }}" alt="Innovación Constante">
                    <div class="valor-overlay">
                        <span class="valor-number">02</span>
                    </div>
                </div>
                <div class="valor-content">
                    <h3>Innovación</h3>
                    <p>
                        Buscamos constantemente nuevas tecnologías y fórmulas para ofrecer soluciones
                        efectivas y modernas que se adapten a las necesidades cambiantes de nuestros clientes.
                    </p>
                </div>
            </div>

            <!-- Valor 3: Integridad -->
            <div class="valor-card">
                <div class="valor-image">
                    <img src="{{ asset('assets/images/valores/integridad.jpg') }}" alt="Integridad y Ética">
                    <div class="valor-overlay">
                        <span class="valor-number">03</span>
                    </div>
                </div>
                <div class="valor-content">
                    <h3>Integridad</h3>
                    <p>
                        Actuamos con transparencia, honestidad y ética en todas nuestras relaciones,
                        desde nuestros proveedores hasta nuestros clientes finales.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Compromiso -->
    <section class="compromiso-section">
        <div class="compromiso-container">
            <h2>Nuestro Compromiso</h2>
            <p class="compromiso-text">
                Más que una empresa de cosméticos, somos una familia dedicada al bienestar de nuestros clientes.
                Cada producto que sale de nuestra planta lleva consigo la promesa de calidad y el cariño
                de todo nuestro equipo.
            </p>

            <div class="compromiso-stats">
                <div class="stat-item">
                    <span class="stat-number">+15</span>
                    <span class="stat-label">Años de Experiencia</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">+50</span>
                    <span class="stat-label">Productos Desarrollados</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Clientes Satisfechos</span>
                </div>
            </div>
        </div>
    </section>
@endsection