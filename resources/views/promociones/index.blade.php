<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Promociones') }}
            </h2>
            <a href="{{ route('promociones.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nueva Promoción
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

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Desktop Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hidden md:block">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Inicio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha Fin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fotos</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($promociones as $promocion)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $promocion->titulo }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($promocion->descripcion, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($promocion->precio)
                                            Bs. {{ number_format($promocion->precio, 2) }}
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $promocion->fecha_inicio->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $promocion->fecha_fin->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($promocion->esta_activa)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-semibold">
                                                Activa
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                                Inactiva
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-semibold">
                                            {{ $promocion->fotos->count() }} fotos
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('promociones.show', $promocion) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                        <a href="{{ route('promociones.edit', $promocion) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                        <form action="{{ route('promociones.destroy', $promocion) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar promoción?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        No hay promociones registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $promociones->links() }}
                    </div>
                </div>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-4">
                @forelse($promociones as $promocion)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $promocion->titulo }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full {{ $promocion->esta_activa ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $promocion->esta_activa ? 'Activa' : 'Inactiva' }}
                                </span>
                            </div>

                            @if($promocion->precio)
                                <p class="text-xl font-bold text-blue-600 mb-2">Bs. {{ number_format($promocion->precio, 2) }}</p>
                            @endif

                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($promocion->descripcion, 80) }}</p>

                            <div class="text-xs text-gray-500 mb-3">
                                <p><strong>Inicio:</strong> {{ $promocion->fecha_inicio->format('d/m/Y') }}</p>
                                <p><strong>Fin:</strong> {{ $promocion->fecha_fin->format('d/m/Y') }}</p>
                                <p><strong>Fotos:</strong> {{ $promocion->fotos->count() }}</p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('promociones.show', $promocion) }}" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white text-center font-bold py-2 px-4 rounded text-sm">Ver</a>
                                <a href="{{ route('promociones.edit', $promocion) }}" class="flex-1 bg-indigo-500 hover:bg-indigo-700 text-white text-center font-bold py-2 px-4 rounded text-sm">Editar</a>
                                <form action="{{ route('promociones.destroy', $promocion) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">No hay promociones</div>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $promociones->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
