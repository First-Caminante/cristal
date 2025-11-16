<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Cliente') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('clientes.edit', $cliente) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Datos básicos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Información Personal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nombres</p>
                            <p class="text-base text-gray-900">{{ $cliente->nombres }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Apellidos</p>
                            <p class="text-base text-gray-900">{{ $cliente->apellidos }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Cédula de Identidad</p>
                            <p class="text-base text-gray-900">{{ $cliente->cedula_identidad ?? 'No registrada' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Correo Electrónico</p>
                            <p class="text-base text-gray-900">{{ $cliente->correo ?? 'No registrado' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Registrado el</p>
                            <p class="text-base text-gray-900">{{ $cliente->creado_en->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teléfonos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Teléfonos</h3>
                    @if($cliente->telefonos->count() > 0)
                        <div class="space-y-3">
                            @foreach($cliente->telefonos as $telefono)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                    <div>
                                        <p class="text-base font-semibold text-gray-900">{{ $telefono->telefono }}</p>
                                        <p class="text-sm text-gray-600">{{ $telefono->descripcion ?? 'Sin descripción' }}</p>
                                    </div>
                                    @if($telefono->es_principal)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Principal
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No hay teléfonos registrados</p>
                    @endif
                </div>
            </div>

            <!-- Dirección -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Dirección</h3>
                    @if($cliente->direccion)
                        <div class="space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Zona</p>
                                    <p class="text-base text-gray-900">{{ $cliente->direccion->zona }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Calle</p>
                                    <p class="text-base text-gray-900">{{ $cliente->direccion->calle }}</p>
                                </div>

                                @if($cliente->direccion->coordenadas)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Coordenadas</p>
                                    <p class="text-base text-gray-900">{{ $cliente->direccion->coordenadas }}</p>
                                </div>
                                @endif

                                @if($cliente->direccion->referencia)
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Referencia</p>
                                    <p class="text-base text-gray-900">{{ $cliente->direccion->referencia }}</p>
                                </div>
                                @endif
                            </div>

                            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm font-medium text-blue-900">Dirección completa:</p>
                                <p class="text-base text-blue-800">{{ $cliente->direccion->direccion_completa }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500">No hay dirección registrada</p>
                    @endif
                </div>
            </div>

            <!-- Fotos del local -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Fotos del Local</h3>
                    @if($cliente->fotos->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($cliente->fotos as $foto)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $foto->ruta_foto) }}"
                                         alt="{{ $foto->descripcion }}"
                                         class="h-48 w-full object-cover rounded-lg shadow-md cursor-pointer hover:shadow-xl transition"
                                         onclick="openModal('{{ asset('storage/' . $foto->ruta_foto) }}')">
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-2 rounded-b-lg opacity-0 group-hover:opacity-100 transition">
                                        <p class="text-xs text-white text-center">{{ $foto->descripcion }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No hay fotos registradas</p>
                    @endif
                </div>
            </div>

            <!-- Botón de eliminar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Zona de Peligro</h3>
                    <p class="text-sm text-gray-600 mb-4">Una vez eliminado el cliente, todos sus datos serán eliminados permanentemente.</p>
                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este cliente? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                            Eliminar Cliente
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal para ver imagen en grande -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4" onclick="closeModal()">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-white bg-red-500 hover:bg-red-700 rounded-full p-2">
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
