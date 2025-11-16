<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nuevo Cliente') }}
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

            <form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Datos básicos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Datos Básicos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres *</label>
                                <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos *</label>
                                <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="cedula_identidad" class="block text-sm font-medium text-gray-700">Cédula de Identidad</label>
                                <input type="text" name="cedula_identidad" id="cedula_identidad" value="{{ old('cedula_identidad') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <input type="email" name="correo" id="correo" value="{{ old('correo') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teléfonos (máx 3) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Teléfonos (máximo 3)</h3>
                        <div id="telefonos-container" class="space-y-3">
                            <div class="telefono-item grid grid-cols-1 md:grid-cols-12 gap-2">
                                <div class="md:col-span-5">
                                    <input type="text" name="telefonos[0][numero]" placeholder="Número de teléfono" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="md:col-span-5">
                                    <input type="text" name="telefonos[0][descripcion]" placeholder="Descripción (ej: Personal)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="md:col-span-2">
                                    <span class="text-xs text-gray-500 block mt-2">Principal</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="agregar-telefono" class="mt-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                            + Agregar Teléfono
                        </button>
                    </div>
                </div>

                <!-- Dirección (solo 1) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Dirección</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="zona" class="block text-sm font-medium text-gray-700">Zona *</label>
                                <input type="text" name="direccion[zona]" id="zona" value="{{ old('direccion.zona') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="calle" class="block text-sm font-medium text-gray-700">Calle *</label>
                                <input type="text" name="direccion[calle]" id="calle" value="{{ old('direccion.calle') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="coordenadas" class="block text-sm font-medium text-gray-700">Coordenadas</label>
                                <input type="text" name="direccion[coordenadas]" id="coordenadas" value="{{ old('direccion.coordenadas') }}" placeholder="Ej: -16.5000, -68.1500" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="referencia" class="block text-sm font-medium text-gray-700">Referencia</label>
                                <input type="text" name="direccion[referencia]" id="referencia" value="{{ old('direccion.referencia') }}" placeholder="Ej: Cerca del mercado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fotos (máx 3) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Fotos del Local (máximo 3)</h3>
                        <input type="file" name="fotos[]" id="fotos" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-2 text-sm text-gray-500">Selecciona hasta 3 imágenes (JPG, PNG, GIF - máx 2MB c/u)</p>

                        <div id="preview-fotos" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Agregar teléfonos dinámicamente
        let telefonoCount = 1;
        document.getElementById('agregar-telefono').addEventListener('click', function() {
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

        // Eliminar teléfono
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-telefono')) {
                e.target.closest('.telefono-item').remove();
                telefonoCount--;
                document.getElementById('agregar-telefono').style.display = 'block';
            }
        });

        // Preview de fotos
        document.getElementById('fotos').addEventListener('change', function(e) {
            const preview = document.getElementById('preview-fotos');
            preview.innerHTML = '';

            const files = Array.from(e.target.files).slice(0, 3);

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
    </script>
    @endpush
</x-app-layout>
