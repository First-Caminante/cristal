<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Testimonio') }}
            </h2>
            <a href="{{ route('testimonios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('testimonios.update', $testimonio) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Cliente *</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $testimonio->nombre) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="comentario" class="block text-sm font-medium text-gray-700">Comentario *</label>
                            <textarea name="comentario" id="comentario" rows="5" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('comentario', $testimonio->comentario) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="fuente" class="block text-sm font-medium text-gray-700">Fuente</label>
                                <input type="text" name="fuente" id="fuente" value="{{ old('fuente', $testimonio->fuente) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="fecha_publicacion" class="block text-sm font-medium text-gray-700">Fecha de Publicación *</label>
                                <input type="date" name="fecha_publicacion" id="fecha_publicacion" value="{{ old('fecha_publicacion', $testimonio->fecha_publicacion->format('Y-m-d')) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="visible" id="visible" value="1" {{ old('visible', $testimonio->visible) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="visible" class="ml-2 block text-sm text-gray-900">
                                Visible públicamente
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('testimonios.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Actualizar Testimonio
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
