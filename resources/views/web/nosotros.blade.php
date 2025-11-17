@extends('web.layouts.app')

@section('title', 'Nosotros - Industrias Cristal')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/stylenosotros.css') }}">
@endsection

@section('content')
<!-- HERO SECTION NOSOTROS -->
<section class="nosotros-hero">
    <div class="nosotros-hero-overlay"></div>
    <div class="nosotros-hero-content">
        <h1>Acerca de Nosotros</h1>
        <p>Más de 15 años creando productos de calidad para tu cuidado personal</p>
    </div>
</section>

<!-- NUESTRA HISTORIA -->
<section class="historia-section">
    <div class="historia-container">
        <div class="historia-content">
            <span class="section-label">Nuestra Historia</span>
            <h2>Industrias Cristal</h2>
            <p class="historia-lead">
                Una empresa líder en la fabricación y distribución de productos cosméticos de alta calidad.
            </p>
            <p>
                Con más de 15 años de experiencia en el mercado, nos hemos consolidado como una marca
                de confianza en el cuidado personal. Desde nuestros inicios, hemos mantenido un compromiso
                inquebrantable con la calidad y la innovación.
            </p>
            <p>
                Lo que comenzó como un pequeño emprendimiento familiar, hoy se ha convertido en una
                empresa reconocida a nivel nacional, sirviendo a miles de clientes que confían en
                nuestros productos día a día.
            </p>
        </div>
        <div class="historia-image">
            <img src="{{ asset('assets/images/nosotros/historia.jpg') }}" alt="Historia de Industrias Cristal">
            <div class="image-decoration"></div>
        </div>
    </div>
</section>

<!-- MISIÓN Y VISIÓN -->
<section class="mision-vision-section">
    <div class="mision-vision-container">
        <div class="mision-card">
            <div class="card-icon">
                <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 17L12 22L22 17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M2 12L12 17L22 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Nuestra Misión</h3>
            <p>
                Proporcionar productos cosméticos innovadores y de calidad superior que mejoren
                la vida diaria de nuestros clientes. Utilizamos tecnología de vanguardia y los
                mejores ingredientes para crear fórmulas efectivas y seguras que superen las
                expectativas del mercado.
            </p>
        </div>

        <div class="mision-card">
            <div class="card-icon">
                <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Nuestra Visión</h3>
            <p>
                Ser la empresa líder en productos cosméticos en Bolivia, reconocida por nuestra
                innovación constante, compromiso con la calidad y responsabilidad social.
                Aspiramos a expandir nuestra presencia a nivel internacional, llevando productos
                bolivianos de calidad al mundo.
            </p>
        </div>
    </div>
</section>

<!-- EQUIPO Y EXPERTICIA -->
<section class="equipo-section">
    <div class="equipo-container">
        <div class="equipo-image">
            <img src="{{ asset('assets/images/nosotros/equipo.jpg') }}" alt="Nuestro Equipo">
        </div>
        <div class="equipo-content">
            <span class="section-label">Nuestro Equipo</span>
            <h2>Especialistas Comprometidos</h2>
            <p>
                Contamos con un equipo multidisciplinario de especialistas en cosmética y dermatología
                que trabajan constantemente en el desarrollo de nuevos productos que satisfagan las
                necesidades cambiantes del mercado.
            </p>
            <div class="equipo-features">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M16 21V19C16 17.9391 15.5786 16.9217 14.8284 16.1716C14.0783 15.4214 13.0609 15 12 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="8.5" cy="7" r="4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20 8V14M23 11H17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <h4>Profesionales Capacitados</h4>
                        <p>Personal con formación en cosmética, química y dermatología</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <h4>Investigación Continua</h4>
                        <p>Desarrollo constante de nuevas fórmulas y tecnologías</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M9 11L12 14L22 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <h4>Control de Calidad</h4>
                        <p>Rigurosos estándares en cada etapa de producción</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INSTALACIONES -->
<section class="instalaciones-section">
    <div class="instalaciones-container">
        <div class="instalaciones-header">
            <span class="section-label">Nuestras Instalaciones</span>
            <h2>Tecnología de Vanguardia</h2>
            <p>Contamos con modernas instalaciones equipadas con tecnología de última generación</p>
        </div>

        <div class="instalaciones-grid">
            <div class="instalacion-card">
                <img src="{{ asset('assets/images/nosotros/planta.jpg') }}" alt="Planta de Producción">
                <div class="instalacion-content">
                    <h4>Planta de Producción</h4>
                    <p>Equipada con maquinaria de última generación</p>
                </div>
            </div>

            <div class="instalacion-card">
                <img src="{{ asset('assets/images/nosotros/laboratorio.jpg') }}" alt="Laboratorio">
                <div class="instalacion-content">
                    <h4>Laboratorio de I+D</h4>
                    <p>Investigación y desarrollo de nuevas fórmulas</p>
                </div>
            </div>

            <div class="instalacion-card">
                <img src="{{ asset('assets/images/nosotros/control.jpg') }}" alt="Control de Calidad">
                <div class="instalacion-content">
                    <h4>Control de Calidad</h4>
                    <p>Pruebas rigurosas en cada producto</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CERTIFICACIONES -->
<section class="certificaciones-section">
    <div class="certificaciones-container">
        <h2>Certificaciones y Reconocimientos</h2>
        <p class="certificaciones-subtitle">Cumplimos con los más altos estándares de calidad</p>
        <div class="certificaciones-grid">
            <div class="cert-item">
                <div class="cert-icon">✓</div>
                <p>Certificación ISO 9001</p>
            </div>
            <div class="cert-item">
                <div class="cert-icon">✓</div>
                <p>Productos Dermatológicamente Probados</p>
            </div>
            <div class="cert-item">
                <div class="cert-icon">✓</div>
                <p>Libre de Crueldad Animal</p>
            </div>
            <div class="cert-item">
                <div class="cert-icon">✓</div>
                <p>Ingredientes Naturales Certificados</p>
            </div>
        </div>
    </div>
</section>
@endsection
