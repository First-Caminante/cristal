<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($clienteEspecifico) ? 'Ruta al Cliente' : 'Mapa de Clientes' }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Ver Lista
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Panel de control -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Clientes en el mapa</label>
                            <select id="cliente-selector" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Seleccionar cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente['id'] }}">{{ $cliente['nombre'] }} - {{ $cliente['direccion']['zona'] ?? 'Sin zona' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button id="btn-mi-ubicacion" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                📍 Mi Ubicación
                            </button>
                        </div>

                        <div class="flex items-end">
                            <button id="btn-calcular-ruta" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" disabled>
                                🗺️ Calcular Ruta
                            </button>
                        </div>
                    </div>

                    <div id="ruta-info" class="mt-4 hidden">
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Distancia:</strong> <span id="distancia-texto">-</span> |
                                        <strong>Tiempo:</strong> <span id="tiempo-texto">-</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenedor del mapa -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="map" class="w-full h-[600px] md:h-[700px]"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Mapbox GL JS -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js'></script>

    <script>
        // Configuración de Mapbox
        mapboxgl.accessToken = '{{ $mapboxToken }}';

        // Datos de clientes
        const clientes = @json($clientes);
        const clienteEspecifico = {{ isset($clienteEspecifico) ? 'true' : 'false' }};

        // Variables globales
        let map;
        let userLocation = null;
        let selectedClientId = null;
        let currentRoute = null;
        let markers = [];

        // Inicializar mapa
        function initMap() {
            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [-68.1193, -16.5000], // La Paz, Bolivia
                zoom: 12
            });

            // Agregar controles de navegación
            map.addControl(new mapboxgl.NavigationControl());

            // Agregar control de geolocalización
            const geolocateControl = new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true,
                showUserHeading: true
            });

            map.addControl(geolocateControl);

            // Esperar a que el mapa cargue
            map.on('load', function() {
                // Si es cliente específico, seleccionarlo automáticamente
                if (clienteEspecifico && clientes.length > 0) {
                    selectedClientId = clientes[0].id;
                    document.getElementById('cliente-selector').value = selectedClientId;
                }

                // Agregar marcadores de clientes
                addClientMarkers();

                // Ajustar vista a todos los clientes
                if (clientes.length > 0) {
                    fitBoundsToClients();
                }
            });

            // Activar geolocalización automáticamente
            geolocateControl.on('geolocate', function(e) {
                userLocation = [e.coords.longitude, e.coords.latitude];
                document.getElementById('btn-calcular-ruta').disabled = !selectedClientId;
            });
        }

        // Agregar marcadores de clientes
        function addClientMarkers() {
            clientes.forEach(cliente => {
                const coords = getClientCoordinates(cliente);
                if (!coords) return;

                // Crear elemento HTML personalizado para el marcador
                const el = document.createElement('div');
                el.className = 'custom-marker';
                el.innerHTML = `
                    <div class="w-10 h-10 bg-red-500 rounded-full border-4 border-white shadow-lg flex items-center justify-center cursor-pointer hover:bg-red-600 transition">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                `;

                // Crear popup con información del cliente
                const popupContent = createClientPopup(cliente);

                const popup = new mapboxgl.Popup({
                    offset: 25,
                    maxWidth: '300px'
                }).setHTML(popupContent);

                // Crear marcador
                const marker = new mapboxgl.Marker(el)
                    .setLngLat(coords)
                    .setPopup(popup)
                    .addTo(map);

                markers.push({ id: cliente.id, marker });

                // Click en el marcador
                el.addEventListener('click', () => {
                    selectedClientId = cliente.id;
                    document.getElementById('cliente-selector').value = cliente.id;
                    document.getElementById('btn-calcular-ruta').disabled = !userLocation;
                });
            });
        }

        // Crear contenido del popup
        function createClientPopup(cliente) {
            let fotosHtml = '';
            if (cliente.fotos && cliente.fotos.length > 0) {
                fotosHtml = `
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        ${cliente.fotos.slice(0, 4).map(foto => `
                            <img src="${foto.url}" alt="${foto.descripcion}"
                                 class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75"
                                 onclick="window.open('${foto.url}', '_blank')">
                        `).join('')}
                    </div>
                `;
            }

            return `
                <div class="p-2">
                    <h3 class="font-bold text-lg text-gray-900">${cliente.nombre}</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        <strong>📍</strong> ${cliente.direccion?.completa || 'Sin dirección'}
                    </p>
                    ${cliente.telefono ? `
                        <p class="text-sm text-gray-600 mt-1">
                            <strong>📞</strong> ${cliente.telefono}
                        </p>
                    ` : ''}
                    ${cliente.direccion?.referencia ? `
                        <p class="text-sm text-gray-600 mt-1">
                            <strong>ℹ️</strong> ${cliente.direccion.referencia}
                        </p>
                    ` : ''}
                    ${fotosHtml}
                    <div class="mt-2">
                        <a href="/clientes/${cliente.id}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Ver detalles →
                        </a>
                    </div>
                </div>
            `;
        }

        // Obtener coordenadas del cliente
        function getClientCoordinates(cliente) {
            if (cliente.direccion?.coordenadas) {
                const coords = cliente.direccion.coordenadas.split(',').map(c => parseFloat(c.trim()));
                if (coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
                    return [coords[1], coords[0]]; // [lng, lat]
                }
            }
            return null;
        }

        // Ajustar vista a todos los clientes
        function fitBoundsToClients() {
            const bounds = new mapboxgl.LngLatBounds();

            clientes.forEach(cliente => {
                const coords = getClientCoordinates(cliente);
                if (coords) {
                    bounds.extend(coords);
                }
            });

            if (!bounds.isEmpty()) {
                map.fitBounds(bounds, {
                    padding: 50,
                    maxZoom: 15
                });
            }
        }

        // Calcular ruta
        async function calculateRoute() {
            if (!userLocation || !selectedClientId) {
                alert('Por favor, activa tu ubicación y selecciona un cliente');
                return;
            }

            const cliente = clientes.find(c => c.id === selectedClientId);
            const clientCoords = getClientCoordinates(cliente);

            if (!clientCoords) {
                alert('El cliente no tiene coordenadas válidas');
                return;
            }

            // Limpiar ruta anterior
            if (currentRoute && map.getLayer('route')) {
                map.removeLayer('route');
                map.removeSource('route');
            }

            // Solicitar ruta a Mapbox Directions API
            const url = `https://api.mapbox.com/directions/v5/mapbox/driving/${userLocation[0]},${userLocation[1]};${clientCoords[0]},${clientCoords[1]}?geometries=geojson&access_token=${mapboxgl.accessToken}`;

            try {
                const response = await fetch(url);
                const data = await response.json();

                if (data.routes && data.routes.length > 0) {
                    const route = data.routes[0];

                    // Agregar ruta al mapa
                    map.addSource('route', {
                        type: 'geojson',
                        data: {
                            type: 'Feature',
                            properties: {},
                            geometry: route.geometry
                        }
                    });

                    map.addLayer({
                        id: 'route',
                        type: 'line',
                        source: 'route',
                        layout: {
                            'line-join': 'round',
                            'line-cap': 'round'
                        },
                        paint: {
                            'line-color': '#3b82f6',
                            'line-width': 5,
                            'line-opacity': 0.75
                        }
                    });

                    // Ajustar vista a la ruta
                    const bounds = new mapboxgl.LngLatBounds();
                    bounds.extend(userLocation);
                    bounds.extend(clientCoords);
                    map.fitBounds(bounds, { padding: 100 });

                    // Mostrar información de la ruta
                    const distancia = (route.distance / 1000).toFixed(2);
                    const tiempo = Math.round(route.duration / 60);

                    document.getElementById('distancia-texto').textContent = `${distancia} km`;
                    document.getElementById('tiempo-texto').textContent = `${tiempo} min`;
                    document.getElementById('ruta-info').classList.remove('hidden');

                    currentRoute = route;
                }
            } catch (error) {
                console.error('Error al calcular ruta:', error);
                alert('Error al calcular la ruta');
            }
        }

        // Event Listeners
        document.getElementById('cliente-selector').addEventListener('change', function(e) {
            selectedClientId = e.target.value ? parseInt(e.target.value) : null;
            document.getElementById('btn-calcular-ruta').disabled = !userLocation || !selectedClientId;

            // Centrar en el cliente seleccionado
            if (selectedClientId) {
                const cliente = clientes.find(c => c.id === selectedClientId);
                const coords = getClientCoordinates(cliente);
                if (coords) {
                    map.flyTo({
                        center: coords,
                        zoom: 15
                    });

                    // Abrir popup del cliente
                    const markerData = markers.find(m => m.id === selectedClientId);
                    if (markerData) {
                        markerData.marker.togglePopup();
                    }
                }
            }
        });

        document.getElementById('btn-mi-ubicacion').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLocation = [position.coords.longitude, position.coords.latitude];

                        map.flyTo({
                            center: userLocation,
                            zoom: 15
                        });

                        // Agregar marcador de usuario si no existe
                        if (!document.getElementById('user-marker')) {
                            const el = document.createElement('div');
                            el.id = 'user-marker';
                            el.className = 'w-4 h-4 bg-blue-500 rounded-full border-2 border-white shadow-lg';

                            new mapboxgl.Marker(el)
                                .setLngLat(userLocation)
                                .addTo(map);
                        }

                        document.getElementById('btn-calcular-ruta').disabled = !selectedClientId;
                    },
                    (error) => {
                        alert('No se pudo obtener tu ubicación: ' + error.message);
                    },
                    {
                        enableHighAccuracy: true
                    }
                );
            } else {
                alert('Tu navegador no soporta geolocalización');
            }
        });

        document.getElementById('btn-calcular-ruta').addEventListener('click', calculateRoute);

        // Inicializar mapa cuando cargue el DOM
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
    @endpush
</x-app-layout>
