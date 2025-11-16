<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nueva Promoción') }}
            </h2>
            <a href="{{ route('promociones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('promociones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Datos de la promoción -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Promoción</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="titulo" class="block text-sm font-medium text-gray-700">Título *</label>
                                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                <textarea name="descripcion" id="descripcion" rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio (Bs.)</label>
                                    <input type="number" name="precio" id="precio" value="{{ old('precio') }}" step="0.01" min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio *</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', date('Y-m-d')) }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha Fin *</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fotos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Fotos de la Promoción</h3>
                        <input type="file" name="fotos[]" id="fotos" accept="image/*" multiple
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-2 text-sm text-gray-500">Puedes seleccionar múltiples imágenes (JPG, PNG, GIF - máx 2MB c/u)</p>

                        <div id="preview-fotos" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('promociones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Guardar Promoción
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview de fotos
        document.getElementById('fotos').addEventListener('change', function(e) {
            const preview = document.getElementById('preview-fotos');
            preview.innerHTML = '';

            const files = Array.from(e.target.files);

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

        // Validar que fecha_fin sea mayor o igual a fecha_inicio
        document.getElementById('fecha_fin').addEventListener('change', function() {
            const fechaInicio = document.getElementById('fecha_inicio').value;
            const fechaFin = this.value;

            if (fechaInicio && fechaFin && fechaFin < fechaInicio) {
                alert('La fecha de fin debe ser igual o posterior a la fecha de inicio');
                this.value = fechaInicio;
            }
        });
    </script>
    @endpush
</x-app-layout>
