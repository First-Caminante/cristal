<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Usuario') }}
            </h2>
            <div class="space-x-2">
                @if($usuario->id !== auth()->id())
                    <a href="{{ route('usuarios.edit', $usuario) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                        Editar
                    </a>
                @endif
                <a href="{{ route('usuarios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Información Personal -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="h-20 w-20 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-3xl mr-4">
                            {{ strtoupper(substr($usuario->nombre, 0, 1)) }}{{ strtoupper(substr($usuario->apellido, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $usuario->nombre_completo }}</h3>
                            <p class="text-sm text-gray-500">{{ $usuario->correo }}</p>
                        </div>
                        <div class="ml-auto">
                            <span class="px-3 py-2 text-sm font-semibold rounded-full
                                {{ $usuario->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $usuario->estado ? '✓ Activo' : '✗ Inactivo' }}
                            </span>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Información Personal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nombre</p>
                            <p class="text-base text-gray-900">{{ $usuario->nombre }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Apellido</p>
                            <p class="text-base text-gray-900">{{ $usuario->apellido }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Correo Electrónico</p>
                            <p class="text-base text-gray-900">{{ $usuario->correo }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Teléfono</p>
                            <p class="text-base text-gray-900">{{ $usuario->telefono ?? 'No registrado' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rol y Permisos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Rol y Permisos</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Rol del Sistema</p>
                            <span class="px-4 py-2 text-base font-semibold rounded-full inline-block
                                @if($usuario->role->nombre === 'superadmin') bg-purple-100 text-purple-800
                                @elseif($usuario->role->nombre === 'administrador') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($usuario->role->nombre) }}
                            </span>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-700 mb-2">Permisos del rol:</p>
                            <ul class="space-y-1 text-sm text-gray-600">
                                @if($usuario->isSuperAdmin())
                                    <li>✓ Acceso total al sistema</li>
                                    <li>✓ Gestión de usuarios y roles</li>
                                    <li>✓ Gestión de clientes</li>
                                    <li>✓ Gestión de testimonios</li>
                                    <li>✓ Gestión de promociones</li>
                                    <li>✓ Visualización de reportes</li>
                                @elseif($usuario->isAdmin())
                                    <li>✓ Gestión de clientes</li>
                                    <li>✓ Gestión de testimonios</li>
                                    <li>✓ Gestión de promociones</li>
                                    <li>✓ Visualización de reportes</li>
                                    <li>✗ Gestión de usuarios (solo lectura)</li>
                                @else
                                    <li>✓ Visualización de clientes</li>
                                    <li>✓ Acceso limitado al dashboard</li>
                                    <li>✗ Sin permisos de edición</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Información del Sistema</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Registrado el</p>
                            <p class="text-base text-gray-900">{{ $usuario->creado_en->format('d/m/Y H:i') }}</p>
                            <p class="text-xs text-gray-500">{{ $usuario->creado_en->diffForHumans() }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">ID de Usuario</p>
                            <p class="text-base text-gray-900">#{{ $usuario->id }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Estado de la Cuenta</p>
                            <p class="text-base text-gray-900">
                                @if($usuario->estado)
                                    <span class="text-green-600">● Activa - Puede iniciar sesión</span>
                                @else
                                    <span class="text-red-600">● Inactiva - No puede iniciar sesión</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones del Sistema -->
            @if($usuario->id !== auth()->id())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">Acciones del Sistema</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('usuarios.edit', $usuario) }}"
                           class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Editar Usuario
                        </a>

                        <form action="{{ route('usuarios.toggle-estado', $usuario) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded">
                                {{ $usuario->estado ? 'Desactivar Usuario' : 'Activar Usuario' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Zona de Peligro -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Zona de Peligro</h3>
                    <p class="text-sm text-gray-600 mb-4">Una vez eliminado el usuario, todos sus datos serán eliminados permanentemente.</p>
                    <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                            Eliminar Usuario
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Este es tu propio perfil. No puedes desactivarte o eliminar tu propia cuenta.
                            Puedes editar tu información desde la sección de <a href="{{ route('profile.edit') }}" class="font-medium underline">Perfil</a>.
                        </p>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
