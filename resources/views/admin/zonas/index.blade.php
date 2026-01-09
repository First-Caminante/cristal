<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Zonas de Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Crear Nueva Zona -->
                    <div class="mb-8 p-4 border rounded-lg bg-gray-50">
                        <h3 class="text-lg font-medium mb-4">Crear Nueva Zona (Carpeta)</h3>
                        <form action="{{ route('zonas.store') }}" method="POST" class="flex gap-4">
                            @csrf
                            <input type="text" name="nombre" placeholder="Nombre de la zona (ej: Zona Sur)" required
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded transition">
                                Crear Zona
                            </button>
                        </form>
                    </div>

                    <!-- Listado de Zonas -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium mb-4">Zonas Existentes</h3>
                        @forelse($zonas as $zona)
                            <div class="border rounded-lg p-4 bg-white shadow-sm">
                                <div class="flex justify-between items-center mb-4 border-b pb-2">
                                    <h4 class="text-xl font-bold text-indigo-800">{{ $zona['nombre'] }}</h4>
                                    <form action="{{ route('zonas.destroy', $zona['id']) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar esta zona?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Eliminar Zona
                                        </button>
                                    </form>
                                </div>

                                <form action="{{ route('zonas.update', $zona['id']) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Renombrar
                                                Zona</label>
                                            <input type="text" name="nombre" value="{{ $zona['nombre'] }}"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Asignar
                                                Clientes</label>
                                            <div class="max-h-48 overflow-y-auto border rounded p-2 bg-gray-50">
                                                @foreach($clientes as $cliente)
                                                    <div class="flex items-center mb-1">
                                                        <input type="checkbox" name="clientes[]" value="{{ $cliente->id }}"
                                                            id="zona-{{ $zona['id'] }}-cli-{{ $cliente->id }}"
                                                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                            {{ in_array($cliente->id, $zona['clientes']) ? 'checked' : '' }}>
                                                        <label for="zona-{{ $zona['id'] }}-cli-{{ $cliente->id }}"
                                                            class="ml-2 text-sm text-gray-600">
                                                            {{ $cliente->nombre_completo }}
                                                            ({{ $cliente->direccion->zona ?? 'N/A' }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-end">
                                        <button type="submit"
                                            class="bg-gray-800 hover:bg-black text-white py-2 px-4 rounded text-sm transition">
                                            Guardar Cambios
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 italic">No hay zonas creadas todavía.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>