<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Clientes') }}
            </h2>
            <a href="{{ route('clientes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nuevo Cliente
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes de éxito/error -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Formulario de búsqueda -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('clientes.buscar') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="tipo_busqueda" class="block text-sm font-medium text-gray-700">Buscar por:</label>
                                <select name="tipo_busqueda" id="tipo_busqueda" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="nombre" {{ (isset($tipoBusqueda) && $tipoBusqueda == 'nombre') ? 'selected' : '' }}>Nombre</option>
                                    <option value="zona" {{ (isset($tipoBusqueda) && $tipoBusqueda == 'zona') ? 'selected' : '' }}>Zona</option>
                                    <option value="telefono" {{ (isset($tipoBusqueda) && $tipoBusqueda == 'telefono') ? 'selected' : '' }}>Teléfono</option>
                                </select>
                            </div>

                            <div>
                                <label for="termino" class="block text-sm font-medium text-gray-700">Término de búsqueda:</label>
                                <input type="text" name="termino" id="termino" value="{{ $termino ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ingrese el término...">
                            </div>

                            <div class="flex items-end space-x-2">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Buscar
                                </button>
                                <a href="{{ route('clientes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de clientes (Desktop) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hidden md:block">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zona</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fotos</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($clientes as $cliente)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $cliente->nombre_completo }}</div>
                                            <div class="text-sm text-gray-500">{{ $cliente->correo }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $cliente->cedula_identidad ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $cliente->telefonos->first()->telefono ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $cliente->direccion->zona ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $cliente->fotos->count() }} fotos
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('clientes.show', $cliente) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                            <a href="{{ route('clientes.edit', $cliente) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No hay clientes registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {{ $clientes->links() }}
                    </div>
                </div>
            </div>

            <!-- Cards para móvil -->
            <div class="md:hidden space-y-4">
                @forelse($clientes as $cliente)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $cliente->nombre_completo }}</h3>
                                    <p class="text-sm text-gray-500">{{ $cliente->correo }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $cliente->fotos->count() }} fotos
                                </span>
                            </div>

                            <div class="space-y-1 text-sm text-gray-600 mb-3">
                                <p><strong>CI:</strong> {{ $cliente->cedula_identidad ?? 'N/A' }}</p>
                                <p><strong>Teléfono:</strong> {{ $cliente->telefonos->first()->telefono ?? 'N/A' }}</p>
                                <p><strong>Zona:</strong> {{ $cliente->direccion->zona ?? 'N/A' }}</p>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('clientes.show', $cliente) }}" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded text-sm">
                                    Ver
                                </a>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="flex-1 bg-indigo-500 hover:bg-indigo-700 text-white text-center font-bold py-2 px-4 rounded text-sm">
                                    Editar
                                </a>
                                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            No hay clientes registrados
                        </div>
                    </div>
                @endforelse

                <!-- Paginación móvil -->
                <div class="mt-4">
                    {{ $clientes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
