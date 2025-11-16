<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Testimonios') }}
            </h2>
            <a href="{{ route('testimonios.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nuevo Testimonio
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Desktop Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hidden md:block">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comentario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fuente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Visible</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($testimonios as $testimonio)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $testimonio->nombre }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500">{{ Str::limit($testimonio->comentario, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $testimonio->fuente ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $testimonio->fecha_publicacion->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('testimonios.toggle', $testimonio) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full {{ $testimonio->visible ? 'bg-green-500' : 'bg-gray-300' }}">
                                                <span class="inline-block h-4 w-4 transform rounded-full bg-white transition {{ $testimonio->visible ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('testimonios.show', $testimonio) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                        <a href="{{ route('testimonios.edit', $testimonio) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <form action="{{ route('testimonios.destroy', $testimonio) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar testimonio?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No hay testimonios registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $testimonios->links() }}
                    </div>
                </div>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4">
                @forelse($testimonios as $testimonio)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $testimonio->nombre }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full {{ $testimonio->visible ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $testimonio->visible ? 'Visible' : 'Oculto' }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($testimonio->comentario, 100) }}</p>
                            <p class="text-xs text-gray-500 mb-3">
                                <strong>Fuente:</strong> {{ $testimonio->fuente ?? 'N/A' }} |
                                <strong>Fecha:</strong> {{ $testimonio->fecha_publicacion->format('d/m/Y') }}
                            </p>

                            <div class="flex gap-2">
                                <a href="{{ route('testimonios.show', $testimonio) }}" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded text-sm">Ver</a>
                                <a href="{{ route('testimonios.edit', $testimonio) }}" class="flex-1 bg-indigo-500 hover:bg-indigo-700 text-white text-center font-bold py-2 px-4 rounded text-sm">Editar</a>
                                <form action="{{ route('testimonios.destroy', $testimonio) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">No hay testimonios</div>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $testimonios->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
