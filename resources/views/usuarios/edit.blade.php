<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Usuario') }}: {{ $usuario->nombre_completo }}
            </h2>
            <a href="{{ route('usuarios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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

            <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información Personal -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido *</label>
                                <input type="text" name="apellido" id="apellido" value="{{ old('apellido', $usuario->apellido) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico *</label>
                                <input type="email" name="correo" id="correo" value="{{ old('correo', $usuario->correo) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cambiar Contraseña (Opcional) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cambiar Contraseña (Opcional)</h3>
                        <p class="text-sm text-gray-600 mb-4">Deja estos campos vacíos si no deseas cambiar la contraseña</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                                <input type="password" name="password" id="password"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">Mínimo 8 caracteres</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rol y Estado -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Configuración del Sistema</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="rol_id" class="block text-sm font-medium text-gray-700">Rol *</label>
                                <select name="rol_id" id="rol_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        {{ $usuario->id === auth()->id() ? 'disabled' : '' }}>
                                    <option value="">Seleccionar rol...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('rol_id', $usuario->rol_id) == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($usuario->id === auth()->id())
                                    <p class="mt-1 text-sm text-red-500">No puedes cambiar tu propio rol</p>
                                    <input type="hidden" name="rol_id" value="{{ $usuario->rol_id }}">
                                @else
                                    <p class="mt-1 text-sm text-gray-500">
                                        <strong>Superadmin:</strong> Acceso total al sistema<br>
                                        <strong>Administrador:</strong> Gestión de clientes y reportes<br>
                                        <strong>Vendedor:</strong> Acceso limitado
                                    </p>
                                @endif
                            </div>

                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700">Estado *</label>
                                <select name="estado" id="estado" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        {{ $usuario->id === auth()->id() ? 'disabled' : '' }}>
                                    <option value="1" {{ old('estado', $usuario->estado) == '1' ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ old('estado', $usuario->estado) == '0' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @if($usuario->id === auth()->id())
                                    <p class="mt-1 text-sm text-red-500">No puedes desactivarte a ti mismo</p>
                                    <input type="hidden" name="estado" value="{{ $usuario->estado }}">
                                @else
                                    <p class="mt-1 text-sm text-gray-500">Los usuarios inactivos no pueden iniciar sesión</p>
                                @endif
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <strong>Usuario creado:</strong> {{ $usuario->creado_en->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('usuarios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
