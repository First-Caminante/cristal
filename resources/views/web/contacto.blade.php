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

                <a href="https://tiktok.com" target="_blank" class="social-link tiktok">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M16.5 3.5c.7 1.4 2 2.4 3.5 2.6v3.2c-1.7-.1-3.2-.7-4.5-1.7v7.3c0 3.7-3 6.6-6.7 6.6S2 18.6 2 14.9c0-3.7 3-6.6 6.7-6.6.5 0 1 .1 1.5.2v3.4c-.5-.3-.9-.4-1.5-.4-1.8 0-3.2 1.4-3.2 3.3s1.4 3.3 3.2 3.3 3.2-1.4 3.2-3.3V2h3.6c0 .5.1 1 .3 1.5l-.1 0z" />
                    </svg>
                    <span>TikTok</span>
                </a>

                <a href="https://wa.me/59175810004" target="_blank" class="social-link whatsapp">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                    </svg>
                    <span>WhatsApp</span>
                </a>
            </div>
        </div>
    </section>
@endsection