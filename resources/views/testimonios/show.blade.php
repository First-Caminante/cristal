<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle del Testimonio') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('testimonios.edit', $testimonio) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('testimonios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $testimonio->nombre }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Publicado el {{ $testimonio->fecha_publicacion->format('d/m/Y') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $testimonio->visible ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $testimonio->visible ? 'Visible' : 'Oculto' }}
                        </span>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fuente</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $testimonio->fuente ?? 'No especificada' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Registrado el</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $testimonio->created_at->format('d/m/Y H:i') }}</dd>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Comentario</dt>
                                <dd class="mt-1 text-base text-gray-900 whitespace-pre-line">{{ $testimonio->comentario }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Zona de peligro -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Zona de Peligro</h3>
                    <p class="text-sm text-gray-600 mb-4">Esta acción no se puede deshacer.</p>
                    <form action="{{ route('testimonios.destroy', $testimonio) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este testimonio?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                            Eliminar Testimonio
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
