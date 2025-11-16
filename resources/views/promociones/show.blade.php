<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de la Promoción') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('promociones.edit', $promocion) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('promociones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Información principal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ $promocion->titulo }}</h3>
                            @if($promocion->precio)
                                <p class="text-2xl font-bold text-blue-600 mt-2">Bs. {{ number_format($promocion->precio, 2) }}</p>
                            @endif
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $promocion->esta_activa ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $promocion->esta_activa ? '✓ Activa' : 'Inactiva' }}
                        </span>
                    </div>

                    @if($promocion->descripcion)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Descripción</h4>
                            <p class="text-base text-gray-900 whitespace-pre-line">{{ $promocion->descripcion }}</p>
                        </div>
                    @endif

                    <div class="border-t border-gray-200 pt-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha de Inicio</dt>
                                <dd class="mt-1 text-base text-gray-900">{{ $promocion->fecha_inicio->format('d/m/Y') }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha de Fin</dt>
                                <dd class="mt-1 text-base text-gray-900">{{ $promocion->fecha_fin->format('d/m/Y') }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duración</dt>
                                <dd class="mt-1 text-base text-gray-900">
                                    {{ $promocion->fecha_inicio->diffInDays($promocion->fecha_fin) + 1 }} días
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Registrada el</dt>
                                <dd class="mt-1 text-base text-gray-900">{{ $promocion->creado_en->format('d/m/Y H:i') }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Total de Fotos</dt>
                                <dd class="mt-1 text-base text-gray-900">{{ $promocion->fotos->count() }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Galería de fotos -->
            @if($promocion->fotos->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Galería de Fotos</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($promocion->fotos as $foto)
                                <div class="relative group cursor-pointer" onclick="openModal('{{ asset('storage/' . $foto->ruta_foto) }}')">
                                    <img src="{{ asset('storage/' . $foto->ruta_foto) }}"
                                         alt="Foto de promoción"
                                         class="h-48 w-full object-cover rounded-lg shadow-md group-hover:shadow-xl transition">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition rounded-lg flex items-center justify-center">
                                        <svg class="h-8 w-8 text-white opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-center text-gray-500">Esta promoción no tiene fotos asociadas</p>
                    </div>
                </div>
            @endif

            <!-- Zona de peligro -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Zona de Peligro</h3>
                    <p class="text-sm text-gray-600 mb-4">Una vez eliminada, todas las fotos asociadas también serán eliminadas permanentemente.</p>
                    <form action="{{ route('promociones.destroy', $promocion) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta promoción? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                            Eliminar Promoción
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal para ver imagen en grande -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeModal()">
        <div class="relative max-w-6xl max-h-full">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-white bg-red-500 hover:bg-red-700 rounded-full p-2 z-10">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="modalImage" src="" alt="Foto ampliada" class="max-w-full max-h-screen rounded-lg">
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Cerrar modal con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
    @endpush
</x-app-layout>
