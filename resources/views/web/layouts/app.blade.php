<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Industrias Cristal - Cosméticos de Calidad')</title>

    {{-- CSS Base --}}
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/whatsapp.css') }}">

    {{-- CSS Específico de cada página --}}
    @yield('css')
</head>

<body>
    {{-- HEADER --}}
    <header>
        <nav>


            {{-- Nombre de la empresa --}}
            <div class="brand-name">Industrias Cristal</div>

            {{-- Botón hamburguesa para móvil --}}
            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('web.home') }}">Inicio</a></li>

                {{-- DROPDOWN DE PRODUCTOS DINÁMICO --}}
                <li class="dropdown">
                    <a href="{{ route('web.productos') }}">Productos</a>
                    @if(isset($categoriasGlobal) && $categoriasGlobal->count() > 0)
                        <ul class="dropdown-menu">
                            @foreach($categoriasGlobal as $cat)
                                <li><a href="{{ route('web.productos', ['categoria' => $cat->slug]) }}">{{ $cat->nombre }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>

                <li><a href="{{ route('web.nosotros') }}">Nosotros</a></li>
                <li><a href="{{ route('web.valores') }}">Valores</a></li>
                <li><a href="{{ route('web.contacto') }}">Contacto</a></li>
            </ul>

            {{-- Botón de Login para empleados --}}
            <a href="{{ route('login') }}" class="login-button" title="Acceso para Personal">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path
                        d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="login-text">Personal</span>
            </a>
        </nav>
    </header>

    {{-- CONTENIDO PRINCIPAL --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer id="contacto">
        <div class="footer-content">
            {{-- Redes sociales --}}
            <div class="footer-social">
                <div class="social-icons">
                    <a href="https://www.facebook.com/Cristalindustriasbo" target="_blank" rel="noopener noreferrer"
                        aria-label="Facebook">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>

                    <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M16.5 3.5c.7 1.4 2 2.4 3.5 2.6v3.2c-1.7-.1-3.2-.7-4.5-1.7v7.3c0 3.7-3 6.6-6.7 6.6S2 18.6 2 14.9c0-3.7 3-6.6 6.7-6.6.5 0 1 .1 1.5.2v3.4c-.5-.3-.9-.4-1.5-.4-1.8 0-3.2 1.4-3.2 3.3s1.4 3.3 3.2 3.3 3.2-1.4 3.2-3.3V2h3.6c0 .5.1 1 .3 1.5l-.1 0z" />
                        </svg>
                    </a>
                    <a href="https://wa.me/59175810004" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Enlaces horizontales --}}
            <nav class="footer-links">
                <a href="{{ route('web.contacto') }}">Contáctanos</a>
                <a href="#">Preguntas Frecuentes</a>
                <a href="#">Mapa Del Sitio</a>
                <a href="#">Aviso de Cookies</a>
                <a href="#">Aviso Legal</a>
                <a href="#">Aviso de Privacidad</a>
            </nav>

            {{-- Copyright con año dinámico --}}
            <div class="footer-bottom">
                <p>&copy; <span id="current-year"></span> Industrias Cristal. Todos Los Derechos Reservados</p>
            </div>
        </div>
    </footer>

    {{-- Botón Flotante de WhatsApp --}}
    <a href="https://wa.me/59175810004" class="whatsapp-float" target="_blank" rel="noopener noreferrer"
        aria-label="Chat on WhatsApp">
        <svg viewBox="0 0 24 24">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
        </svg>
    </a>

    {{-- Scripts --}}
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        // Año dinámico
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Toggle menú móvil
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        const dropdown = document.querySelector('.dropdown');
        const dropdownLink = dropdown.querySelector('a');

        function isMobile() {
            return window.innerWidth <= 968;
        }

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });

        dropdownLink.addEventListener('click', (e) => {
            if (isMobile()) {
                e.preventDefault();
                dropdown.classList.toggle('active');
            }
        });

        const dropdownLinks = document.querySelectorAll('.dropdown-menu a');
        dropdownLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
                dropdown.classList.remove('active');
            });
        });

        const mainNavLinks = document.querySelectorAll('.nav-menu > li > a:not(.dropdown a)');
        mainNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
            });
        });

        document.addEventListener('click', (e) => {
            if (!navMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
                dropdown.classList.remove('active');
            }
        });

        window.addEventListener('resize', () => {
            if (!isMobile()) {
                dropdown.classList.remove('active');
                navMenu.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>