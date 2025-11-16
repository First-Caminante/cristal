<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Cliente') }}: {{ $cliente->nombre_completo }}
            </h2>
            <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('clientes.update', $cliente) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Datos básicos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Datos Básicos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres *</label>
                                <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $cliente->nombres) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos *</label>
                                <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="cedula_identidad" class="block text-sm font-medium text-gray-700">Cédula de Identidad</label>
                                <input type="text" name="cedula_identidad" id="cedula_identidad" value="{{ old('cedula_identidad', $cliente->cedula_identidad) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <input type="email" name="correo" id="correo" value="{{ old('correo', $cliente->correo) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teléfonos (máx 3) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Teléfonos (máximo 3)</h3>
                        <div id="telefonos-container" class="space-y-3">
                            @forelse($cliente->telefonos as $index => $telefono)
                                <div class="telefono-item grid grid-cols-1 md:grid-cols-12 gap-2">
                                    <div class="md:col-span-5">
                                        <input type="text" name="telefonos[{{ $index }}][numero]" value="{{ $telefono->telefono }}" placeholder="Número de teléfono" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="md:col-span-5">
                                        <input type="text" name="telefonos[{{ $index }}][descripcion]" value="{{ $telefono->descripcion }}" placeholder="Descripción" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        @if($index === 0)
                                            <span class="text-xs text-gray-500 block mt-2">Principal</span>
                                        @else
                                            <button type="button" class="remove-telefono bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm w-full">
                                                Eliminar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="telefono-item grid grid-cols-1 md:grid-cols-12 gap-2">
                                    <div class="md:col-span-5">
                                        <input type="text" name="telefonos[0][numero]" placeholder="Número de teléfono" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="md:col-span-5">
                                        <input type="text" name="telefonos[0][descripcion]" placeholder="Descripción" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <span class="text-xs text-gray-500 block mt-2">Principal</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        @if($cliente->telefonos->count() < 3)
                            <button type="button" id="agregar-telefono" class="mt-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                + Agregar Teléfono
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Dirección (solo 1) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Dirección</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="zona" class="block text-sm font-medium text-gray-700">Zona *</label>
                                <input type="text" name="direccion[zona]" id="zona" value="{{ old('direccion.zona', $cliente->direccion->zona ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="calle" class="block text-sm font-medium text-gray-700">Calle *</label>
                                <input type="text" name="direccion[calle]" id="calle" value="{{ old('direccion.calle', $cliente->direccion->calle ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="coordenadas" class="block text-sm font-medium text-gray-700">Coordenadas</label>
                                <input type="text" name="direccion[coordenadas]" id="coordenadas" value="{{ old('direccion.coordenadas', $cliente->direccion->coordenadas ?? '') }}" placeholder="Ej: -16.5000, -68.1500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="referencia" class="block text-sm font-medium text-gray-700">Referencia</label>
                                <input type="text" name="direccion[referencia]" id="referencia" value="{{ old('direccion.referencia', $cliente->direccion->referencia ?? '') }}" placeholder="Ej: Cerca del mercado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fotos actuales y nuevas (máx 3) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Fotos del Local</h3>

                        <!-- Fotos actuales -->
                        @if($cliente->fotos->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Fotos actuales ({{ $cliente->fotos->count() }}/3)</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($cliente->fotos as $foto)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $foto->ruta_foto) }}" alt="Foto {{ $foto->orden }}" class="h-32 w-full object-cover rounded-lg shadow">
                                            <label class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded cursor-pointer hover:bg-red-700">
                                                <input type="checkbox" name="fotos_eliminar[]" value="{{ $foto->id }}" class="hidden">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </label>
                                            <p class="text-xs text-center mt-1 text-gray-600">{{ $foto->descripcion }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Marca las fotos que deseas eliminar</p>
                            </div>
                        @endif

                        <!-- Nuevas fotos -->
                        @if($cliente->fotos->count() < 3)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Agregar nuevas fotos (quedan {{ 3 - $cliente->fotos->count() }} espacios)</h4>
                                <input type="file" name="fotos[]" id="fotos" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-2 text-sm text-gray-500">Puedes agregar hasta {{ 3 - $cliente->fotos->count() }} fotos más</p>

                                <div id="preview-fotos" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Has alcanzado el límite de 3 fotos. Elimina alguna para agregar nuevas.</p>
                        @endif
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Agregar teléfonos dinámicamente
        let telefonoCount = {{ $cliente->telefonos->count() }};
        const agregarBtn = document.getElementById('agregar-telefono');

        if (agregarBtn) {
            agregarBtn.addEventListener('click', function() {
                if (telefonoCount < 3) {
                    const container = document.getElementById('telefonos-container');
                    const newTelefono = `
                        <div class="telefono-item grid grid-cols-1 md:grid-cols-12 gap-2">
                            <div class="md:col-span-5">
                                <input type="text" name="telefonos[${telefonoCount}][numero]" placeholder="Número de teléfono" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-5">
                                <input type="text" name="telefonos[${telefonoCount}][descripcion]" placeholder="Descripción" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <button type="button" class="remove-telefono bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm w-full">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', newTelefono);
                    telefonoCount++;

                    if (telefonoCount >= 3) {
                        this.style.display = 'none';
                    }
                }
            });
        }

        // Eliminar teléfono
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-telefono')) {
                e.target.closest('.telefono-item').remove();
                telefonoCount--;
                if (agregarBtn) {
                    agregarBtn.style.display = 'block';
                }
            }
        });

        // Preview de fotos nuevas
        const fotosInput = document.getElementById('fotos');
        if (fotosInput) {
            fotosInput.addEventListener('change', function(e) {
                const preview = document.getElementById('preview-fotos');
                preview.innerHTML = '';

                const maxFotos = {{ 3 - $cliente->fotos->count() }};
                const files = Array.from(e.target.files).slice(0, maxFotos);

                files.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML += `
                            <div class="relative">
                                <img src="${e.target.result}" class="h-32 w-full object-cover rounded-lg shadow">
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                });
            });
        }
    </script>
    @endpush
</x-app-layout>
