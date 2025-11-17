<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Usuarios') }}
            </h2>
            <a href="{{ route('usuarios.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Nuevo Usuario
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
                    <form action="{{ route('usuarios.buscar') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="tipo_busqueda" class="block text-sm font-medium text-gray-700">Buscar por:</label>
                                <select name="tipo_busqueda" id="tipo_busqueda" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Seleccionar...</option>
                                    <option value="nombre" {{ (isset($tipoBusqueda) && $tipoBusqueda == 'nombre') ? 'selected' : '' }}>Nombre</option>
                                    <option value="correo" {{ (isset($tipoBusqueda) && $tipoBusqueda == 'correo') ? 'selected' : '' }}>Correo</option>
                                    <option value="rol" {{ (isset($tipoBusqueda) && $tipoBusqueda == 'rol') ? 'selected' : '' }}>Rol</option>
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
                                <a href="{{ route('usuarios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de usuarios (Desktop) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hidden md:block">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registrado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($usuarios as $usuario)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}{{ strtoupper(substr($usuario->apellido, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $usuario->nombre_completo }}</div>
                                                    <div class="text-sm text-gray-500">{{ $usuario->correo }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $usuario->telefono ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($usuario->role->nombre === 'superadmin') bg-purple-100 text-purple-800
                                                @elseif($usuario->role->nombre === 'administrador') bg-blue-100 text-blue-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($usuario->role->nombre) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $usuario->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $usuario->creado_en->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('usuarios.show', $usuario) }}" class="text-blue-600 hover:text-blue-900">Ver</a>

                                            @if($usuario->id !== auth()->id())
                                                <a href="{{ route('usuarios.edit', $usuario) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>

                                                <form action="{{ route('usuarios.toggle-estado', $usuario) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                        {{ $usuario->estado ? 'Desactivar' : 'Activar' }}
                                                    </button>
                                                </form>

                                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-xs">(Tú mismo)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No hay usuarios registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {{ $usuarios->links() }}
                    </div>
                </div>
            </div>

            <!-- Cards para móvil -->
            <div class="md:hidden space-y-4">
                @forelse($usuarios as $usuario)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold mr-3">
                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}{{ strtoupper(substr($usuario->apellido, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $usuario->nombre_completo }}</h3>
                                        <p class="text-sm text-gray-500">{{ $usuario->correo }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $usuario->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>

                            <div class="space-y-1 text-sm text-gray-600 mb-3">
                                <p><strong>Teléfono:</strong> {{ $usuario->telefono ?? 'N/A' }}</p>
                                <p><strong>Rol:</strong>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($usuario->role->nombre === 'superadmin') bg-purple-100 text-purple-800
                                        @elseif($usuario->role->nombre === 'administrador') bg-blue-100 text-blue-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ ucfirst($usuario->role->nombre) }}
                                    </span>
                                </p>
                                <p><strong>Registrado:</strong> {{ $usuario->creado_en->format('d/m/Y') }}</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('usuarios.show', $usuario) }}" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded text-sm">
                                    Ver
                                </a>

                                @if($usuario->id !== auth()->id())
                                    <a href="{{ route('usuarios.edit', $usuario) }}" class="flex-1 bg-indigo-500 hover:bg-indigo-700 text-white text-center font-bold py-2 px-4 rounded text-sm">
                                        Editar
                                    </a>

                                    <form action="{{ route('usuarios.toggle-estado', $usuario) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            {{ $usuario->estado ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Estás seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            No hay usuarios registrados
                        </div>
                    </div>
                @endforelse

                <!-- Paginación móvil -->
                <div class="mt-4">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
