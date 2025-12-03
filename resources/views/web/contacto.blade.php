@extends('web.layouts.app')

@section('title', 'Contacto - Industrias Cristal')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/stylecont.css') }}">
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="contact-hero-content">
            <h1>Contáctanos</h1>
            <p>Estamos aquí para escucharte. Ponte en contacto con nosotros por cualquiera de nuestros canales.</p>
        </div>
    </section>

    <!-- Sección de Información de Contacto -->
    <section class="contact-info">
        <div class="contact-container">
            <div class="contact-cards">
                <!-- Teléfono -->
                <div class="contact-card">
                    <div class="card-icon phone">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                            </path>
                        </svg>
                    </div>
                    <h3>Llámanos</h3>
                    <div class="contact-detail">
                        <a href="tel:+59175810004">+591 75810004</a>
                    </div>
                    <div class="contact-detail">
                        <a href="tel:+59122812345">+591 2 2812345</a>
                    </div>
                    <p class="contact-hours">Atención telefónica inmediata</p>
                </div>

                <!-- WhatsApp -->
                <div class="contact-card">
                    <div class="card-icon whatsapp">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                            </path>
                        </svg>
                    </div>
                    <h3>WhatsApp</h3>
                    <p class="contact-address">Escríbenos directamente para consultas rápidas y pedidos.</p>
                    <a href="https://wa.me/59175810004" target="_blank" class="whatsapp-button">Enviar Mensaje</a>
                </div>

                <!-- Email -->
                <div class="contact-card">
                    <div class="card-icon email">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                    <h3>Correo</h3>
                    <div class="contact-detail">
                        <a href="mailto:info@industriascristal.com">info@industriascristal.com</a>
                    </div>
                    <div class="contact-detail">
                        <a href="mailto:ventas@industriascristal.com">ventas@industriascristal.com</a>
                    </div>
                    <p class="contact-hours">Respondemos en 24 horas</p>
                </div>

                <!-- Ubicación -->
                <div class="contact-card">
                    <div class="card-icon location">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h3>Visítanos</h3>
                    <p class="contact-address">
                        Av. 6 de Marzo, Zona Senkata<br>
                        El Alto, La Paz - Bolivia
                    </p>
                    <a href="https://maps.google.com" target="_blank" class="location-button">Ver Mapa</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Horarios -->
    <section class="schedule-section">
        <div class="schedule-container">
            <h2>Horarios de Atención</h2>
            <div class="schedule-grid">
                <div class="schedule-card">
                    <div class="schedule-icon">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <h3>Lunes a Viernes</h3>
                    <p>Mañana: 08:30 - 12:30</p>
                    <p>Tarde: 14:30 - 18:30</p>
                </div>

                <div class="schedule-card">
                    <div class="schedule-icon">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <h3>Sábados</h3>
                    <p>Horario Continuo</p>
                    <p>09:00 - 14:00</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Redes Sociales -->
    <section class="social-section">
        <div class="social-container">
            <h2>Síguenos en Redes</h2>
            <p class="social-subtitle">Mantente al día con nuestras novedades y promociones</p>

            <div class="social-links">
                <a href="https://www.facebook.com/Cristalindustriasbo" target="_blank" class="social-link facebook">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                    <span>Facebook</span>
                </a>

                <a href="https://instagram.com" target="_blank" class="social-link instagram">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                    </svg>
                    <span>Instagram</span>
                </a>

                <a href="https://tiktok.com" target="_blank" class="social-link tiktok">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M16.5 3.5c.7 1.4 2 2.4 3.5 2.6v3.2c-1.7-.1-3.2-.7-4.5-1.7v7.3c0 3.7-3 6.6-6.7 6.6S2 18.6 2 14.9c0-3.7 3-6.6 6.7-6.6.5 0 1 .1 1.5.2v3.4c-.5-.3-.9-.4-1.5-.4-1.8 0-3.2 1.4-3.2 3.3s1.4 3.3 3.2 3.3 3.2-1.4 3.2-3.3V2h3.6c0 .5.1 1 .3 1.5l-.1 0z" />
                    </svg>
                    <span>TikTok</span>
                </a>
            </div>
        </div>
    </section>
@endsection