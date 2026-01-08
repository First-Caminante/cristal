<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($categoria) ? 'Editar Categoría' : 'Nueva Categoría' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form
                        action="{{ isset($categoria) ? route('categorias.update', $categoria) : route('categorias.store') }}"
                        method="POST">
                        @csrf
                        @if(isset($categoria))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la
                                Categoría</label>
                            <input type="text" name="nombre" id="nombre"
                                value="{{ old('nombre', $categoria->nombre ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="estado"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('estado', $categoria->estado ?? true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Categoría Activa</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('categorias.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                {{ isset($categoria) ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>