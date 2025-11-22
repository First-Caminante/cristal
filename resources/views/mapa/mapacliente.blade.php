<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($clienteEspecifico) ? 'Ruta al Cliente' : 'Mapa de Clientes' }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('clientes.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Ver Lista
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-full">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-[calc(100%-4rem)]">
                <div class="p-4 h-full">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 h-full">
                        <!-- Panel Lateral de Clientes -->
                        <div class="md:col-span-1 flex flex-col h-full">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Clientes</label>
                                <input type="text" id="search-input" placeholder="Nombre, zona o teléfono..."
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="flex-1 overflow-y-auto border rounded-md bg-gray-50 mb-4" id="clientes-list">
                                <!-- Lista de clientes se renderiza aquí -->
                                <div class="flex justify-center items-center h-full text-gray-500">
                                    Cargando clientes...
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                                    <span id="selected-count">0 seleccionados</span>
                                    <button
                                        onclick="selectedClientIds.clear(); renderClientList(); updateMapMarkers(); updateUI();"
                                        class="text-red-500 hover:text-red-700 text-xs">
                                        Limpiar selección
                                    </button>
                                </div>

                                <button id="btn-mi-ubicacion"
                                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Mi Ubicación
                                </button>

                                <button id="btn-calcular-ruta"
                                    class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center gap-2 opacity-50 cursor-not-allowed"
                                    disabled>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.447-.894L15 7m0 13V7">
                                        </path>
                                    </svg>
                                    Calcular Ruta
                                </button>
                            </div>
                        </div>

                        <!-- Mapa -->
                        <div class="md:col-span-3 relative h-full">
                            <div id="map" class="w-full h-full rounded-lg shadow-inner"></div>

                            <!-- Info de Ruta Flotante -->
                            <div id="ruta-info"
                                class="absolute top-4 left-4 z-10 hidden bg-white p-4 rounded-lg shadow-lg max-w-sm border-l-4 border-blue-500">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Ruta Calculada</h3>
                                        <div class="mt-1 text-sm text-gray-700">
                                            <p><strong>Distancia:</strong> <span id="distancia-texto">-</span></p>
                                            <p><strong>Tiempo est.:</strong> <span id="tiempo-texto">-</span></p>
                                        </div>
                                    </div>
                                    <button onclick="document.getElementById('ruta-info').classList.add('hidden')"
                                        class="ml-auto text-gray-400 hover:text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            const allClientes = @json($clientes);
            let filteredClientes = [...allClientes];
            const clienteEspecifico = {{ isset($clienteEspecifico) ? 'true' : 'false' }};

            // Variables globales
            let map;
            let userLocation = null;
            let selectedClientIds = new Set();
            let currentRoute = null;
            let markers = [];
            let userMarker = null;

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
                map.on('load', function () {
                    // Si es cliente específico, seleccionarlo automáticamente
                    if (clienteEspecifico && allClientes.length > 0) {
                        const id = allClientes[0].id;
                        selectedClientIds.add(id);
                        renderClientList(); // Renderizar lista para mostrar selección
                        focusOnClient(id);
                    }

                    // Renderizar lista inicial
                    renderClientList();

                    // Agregar marcadores de clientes
                    updateMapMarkers();

                    // Ajustar vista a todos los clientes
                    if (allClientes.length > 0) {
                        fitBoundsToClients(allClientes);
                    }
                });

                // Activar geolocalización automáticamente
                geolocateControl.on('geolocate', function (e) {
                    userLocation = [e.coords.longitude, e.coords.latitude];
                    updateUI();
                });
            }

            // Filtrar clientes
            function filterClients() {
                const searchTerm = document.getElementById('search-input').value.toLowerCase();

                filteredClientes = allClientes.filter(cliente => {
                    const nombre = cliente.nombre ? cliente.nombre.toLowerCase() : '';
                    const zona = cliente.direccion?.zona ? cliente.direccion.zona.toLowerCase() : '';
                    const telefono = cliente.telefono ? cliente.telefono.toLowerCase() : '';

                    return nombre.includes(searchTerm) ||
                        zona.includes(searchTerm) ||
                        telefono.includes(searchTerm);
                });

                renderClientList();
                updateMapMarkers();
            }

            // Renderizar lista de clientes
            function renderClientList() {
                const container = document.getElementById('clientes-list');
                container.innerHTML = '';

                if (filteredClientes.length === 0) {
                    container.innerHTML = '<p class="text-gray-500 text-center py-4">No se encontraron clientes</p>';
                    return;
                }

                filteredClientes.forEach(cliente => {
                    const isSelected = selectedClientIds.has(cliente.id);

                    const item = document.createElement('div');
                    item.className = `p-3 border-b hover:bg-gray-50 cursor-pointer flex items-start space-x-3 ${isSelected ? 'bg-blue-50' : ''}`;
                    item.onclick = (e) => {
                        // Evitar doble disparo si se hace click en el checkbox
                        if (e.target.type !== 'checkbox') {
                            toggleClientSelection(cliente.id);
                        }
                    };

                    item.innerHTML = `
                                                                    <div class="flex items-center h-5 mt-1">
                                                                        <input type="checkbox" 
                                                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                                               ${isSelected ? 'checked' : ''}
                                                                               onchange="toggleClientSelection(${cliente.id})">
                                                                    </div>
                                                                    <div class="flex-1 min-w-0">
                                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                                            ${cliente.nombre}
                                                                        </p>
                                                                        <p class="text-xs text-gray-500 truncate">
                                                                            ${cliente.direccion?.zona || 'Sin zona'}
                                                                        </p>
                                                                        ${cliente.telefono ? `<p class="text-xs text-gray-400">${cliente.telefono}</p>` : ''}
                                                                    </div>
                                                                `;

                    container.appendChild(item);
                });

                updateUI();
            }

            // Toggle selección de cliente
            function toggleClientSelection(id) {
                if (selectedClientIds.has(id)) {
                    selectedClientIds.delete(id);
                    closeClientPopup(id);
                } else {
                    if (selectedClientIds.size >= 24) {
                        alert('Máximo 24 clientes permitidos para la ruta');
                        return;
                    }
                    selectedClientIds.add(id);
                    focusOnClient(id);
                }

                renderClientList();
                updateMarkerStyles(); // Actualizar solo estilos visuales
                updateUI();
            }

            // Actualizar marcadores en el mapa (Recrear todos)
            function updateMapMarkers() {
                // Limpiar marcadores existentes
                markers.forEach(m => m.marker.remove());
                markers = [];

                filteredClientes.forEach(cliente => {
                    const coords = getClientCoordinates(cliente);
                    if (!coords) return;

                    // Crear elemento HTML personalizado para el marcador
                    const el = document.createElement('div');
                    el.className = 'custom-marker';

                    // Renderizar contenido visual del marcador
                    updateMarkerElement(el, selectedClientIds.has(cliente.id));

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

                    markers.push({ id: cliente.id, marker, element: el });

                    // Click en el marcador
                    el.addEventListener('click', (e) => {
                        e.stopPropagation();
                        toggleClientSelection(cliente.id);
                    });
                });
            }

            // Centrar mapa en cliente y abrir popup
            function focusOnClient(id) {
                const client = allClientes.find(c => c.id === id);
                if (!client) return;

                const coords = getClientCoordinates(client);
                if (coords) {
                    map.flyTo({
                        center: coords,
                        zoom: 15
                    });

                    // Buscar el marcador y asegurar que el popup esté abierto
                    const markerObj = markers.find(m => m.id === id);
                    if (markerObj && markerObj.marker.getPopup() && !markerObj.marker.getPopup().isOpen()) {
                        markerObj.marker.togglePopup();
                    }
                }
            }

            // Cerrar popup del cliente
            function closeClientPopup(id) {
                const markerObj = markers.find(m => m.id === id);
                if (markerObj && markerObj.marker.getPopup() && markerObj.marker.getPopup().isOpen()) {
                    markerObj.marker.togglePopup();
                }
            }

            // Actualizar solo el estilo visual de los marcadores existentes
            function updateMarkerStyles() {
                markers.forEach(m => {
                    const isSelected = selectedClientIds.has(m.id);
                    updateMarkerElement(m.element, isSelected);
                });
            }

            // Helper para renderizar el HTML del marcador
            function updateMarkerElement(element, isSelected) {
                const bgColor = isSelected ? 'bg-green-500' : 'bg-red-500';
                const hoverColor = isSelected ? 'hover:bg-green-600' : 'hover:bg-red-600';

                element.innerHTML = `
                                                        <div class="w-8 h-8 ${bgColor} rounded-full border-2 border-white shadow-lg flex items-center justify-center cursor-pointer ${hoverColor} transition transform hover:scale-110">
                                                            <span class="text-white text-xs font-bold">${isSelected ? '✓' : ''}</span>
                                                        </div>
                                                    `;
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

            // Ajustar vista a clientes
            function fitBoundsToClients(clientsToFit) {
                const bounds = new mapboxgl.LngLatBounds();
                let hasValidCoords = false;

                clientsToFit.forEach(cliente => {
                    const coords = getClientCoordinates(cliente);
                    if (coords) {
                        bounds.extend(coords);
                        hasValidCoords = true;
                    }
                });

                if (hasValidCoords) {
                    map.fitBounds(bounds, {
                        padding: 50,
                        maxZoom: 15
                    });
                }
            }

            // Actualizar UI (botones, contadores)
            function updateUI() {
                const count = selectedClientIds.size;
                document.getElementById('selected-count').textContent = `${count} seleccionado${count !== 1 ? 's' : ''}`;

                const btnCalcular = document.getElementById('btn-calcular-ruta');
                if (userLocation && count > 0) {
                    btnCalcular.disabled = false;
                    btnCalcular.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    btnCalcular.disabled = true;
                    btnCalcular.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            // Calcular ruta multipunto
            async function calculateRoute() {
                if (!userLocation || selectedClientIds.size === 0) {
                    alert('Por favor, activa tu ubicación y selecciona al menos un cliente');
                    return;
                }

                // Construir lista de coordenadas: Inicio (Usuario) -> Clientes Seleccionados
                const coordinates = [userLocation];

                // Obtener clientes seleccionados en el orden que aparecen en allClientes (o podríamos mantener orden de selección)
                // Para optimizar ruta, Mapbox tiene Optimization API, pero usaremos Directions API en orden de lista por simplicidad
                // o el orden de selección si lo hubiéramos guardado. Aquí usaremos el orden de la lista filtrada/general.

                // Mejor aproximación: Usar los IDs seleccionados y buscar sus coords
                const selectedClients = allClientes.filter(c => selectedClientIds.has(c.id));

                // Verificar coordenadas válidas
                const validClients = [];
                selectedClients.forEach(client => {
                    const coords = getClientCoordinates(client);
                    if (coords) {
                        validClients.push({ ...client, coords });
                    }
                });

                if (validClients.length === 0) {
                    alert('Ninguno de los clientes seleccionados tiene coordenadas válidas');
                    return;
                }

                // Agregar coordenadas de clientes a la ruta
                validClients.forEach(client => {
                    coordinates.push(client.coords);
                });

                // Construir string de coordenadas para la API
                // Formato: lng,lat;lng,lat;...
                const coordinatesString = coordinates.map(c => `${c[0]},${c[1]}`).join(';');

                // Limpiar ruta anterior
                if (currentRoute) {
                    if (map.getLayer('route')) map.removeLayer('route');
                    if (map.getSource('route')) map.removeSource('route');
                }

                // Solicitar ruta a Mapbox Directions API
                const url = `https://api.mapbox.com/directions/v5/mapbox/driving/${coordinatesString}?geometries=geojson&access_token=${mapboxgl.accessToken}`;

                try {
                    const response = await fetch(url);
                    const data = await response.json();

                    if (data.code !== 'Ok') {
                        throw new Error(data.message || 'Error al calcular ruta');
                    }

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
                        coordinates.forEach(coord => bounds.extend(coord));
                        map.fitBounds(bounds, { padding: 50 });

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
                    alert('Error al calcular la ruta: ' + error.message);
                }
            }

            // Event Listeners
            document.getElementById('search-input').addEventListener('input', filterClients);

            document.getElementById('btn-mi-ubicacion').addEventListener('click', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            userLocation = [position.coords.longitude, position.coords.latitude];

                            map.flyTo({
                                center: userLocation,
                                zoom: 15
                            });

                            // Agregar/Actualizar marcador de usuario
                            if (!userMarker) {
                                const el = document.createElement('div');
                                el.className = 'w-4 h-4 bg-blue-500 rounded-full border-2 border-white shadow-lg pulse-animation';

                                // Añadir estilo de pulso si no existe
                                if (!document.getElementById('pulse-style')) {
                                    const style = document.createElement('style');
                                    style.id = 'pulse-style';
                                    style.innerHTML = `
                                                                                    @keyframes pulse {
                                                                                        0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
                                                                                        70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
                                                                                        100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
                                                                                    }
                                                                                    .pulse-animation {
                                                                                        animation: pulse 2s infinite;
                                                                                    }
                                                                                `;
                                    document.head.appendChild(style);
                                }

                                userMarker = new mapboxgl.Marker(el)
                                    .setLngLat(userLocation)
                                    .addTo(map);
                            } else {
                                userMarker.setLngLat(userLocation);
                            }

                            updateUI();
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