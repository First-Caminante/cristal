<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrar Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data" id="homeForm">
                @csrf
                @method('PUT')

                <!-- SECCIÓN HERO -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Sección Principal (Hero)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="hero_title" :value="__('Título')" />
                                    <x-text-input id="hero_title" class="block mt-1 w-full" type="text"
                                        name="hero_title" :value="old('hero_title', $content['hero']['title'])"
                                        required />
                                    <x-input-error :messages="$errors->get('hero_title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="hero_text" :value="__('Texto')" />
                                    <textarea id="hero_text" name="hero_text" rows="4"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>{{ old('hero_text', $content['hero']['text']) }}</textarea>
                                    <x-input-error :messages="$errors->get('hero_text')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="hero_image" :value="__('Imagen Principal')" />
                                <div class="mt-2 flex items-center gap-4">
                                    <div class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden relative group">
                                        <img src="{{ asset('storage/' . $content['hero']['image']) }}" id="hero_preview"
                                            alt="Hero" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <input type="file" name="hero_image" id="hero_image"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            accept="image/*">
                                        <div class="text-center text-gray-500 text-sm">- O -</div>
                                        <button type="button" onclick="openGallery('hero')"
                                            class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Seleccionar de Biblioteca
                                        </button>
                                        <input type="hidden" name="hero_image_existing" id="hero_image_existing">
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Recomendado: 1920x1080px (Max 10MB)</p>
                                <x-input-error :messages="$errors->get('hero_image')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN PRODUCTO ESTRELLA -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Producto Estrella</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="featured_title" :value="__('Nombre del Producto')" />
                                    <x-text-input id="featured_title" class="block mt-1 w-full" type="text"
                                        name="featured_title" :value="old('featured_title', $content['featured']['title'])" required />
                                    <x-input-error :messages="$errors->get('featured_title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="featured_description" :value="__('Descripción')" />
                                    <textarea id="featured_description" name="featured_description" rows="4"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>{{ old('featured_description', $content['featured']['description']) }}</textarea>
                                    <x-input-error :messages="$errors->get('featured_description')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label :value="__('Beneficios (Uno por línea)')" />
                                    <div class="space-y-2 mt-1">
                                        @foreach($content['featured']['benefits'] as $index => $benefit)
                                            <x-text-input name="featured_benefits[]" class="block w-full" type="text"
                                                :value="$benefit" placeholder="Beneficio {{ $index + 1 }}" />
                                        @endforeach
                                        <!-- Empty input for adding new -->
                                        <x-text-input name="featured_benefits[]" class="block w-full" type="text"
                                            placeholder="Nuevo beneficio..." />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="featured_image" :value="__('Imagen del Producto')" />
                                <div class="mt-2 flex items-center gap-4">
                                    <div class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $content['featured']['image']) }}"
                                            id="featured_preview" alt="Featured" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <input type="file" name="featured_image" id="featured_image"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                            accept="image/*">
                                        <div class="text-center text-gray-500 text-sm">- O -</div>
                                        <button type="button" onclick="openGallery('featured')"
                                            class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Seleccionar de Biblioteca
                                        </button>
                                        <input type="hidden" name="featured_image_existing"
                                            id="featured_image_existing">
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Recomendado: 800x800px (Max 10MB)</p>
                                <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-primary-button>
                        {{ __('Guardar Cambios') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Gallery Modal -->
    <div id="galleryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeGallery()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Biblioteca de Imágenes
                            </h3>
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 max-h-96 overflow-y-auto p-2">
                                @foreach($images as $image)
                                    <div class="relative group cursor-pointer border-2 border-transparent hover:border-indigo-500 rounded-lg overflow-hidden"
                                        onclick="selectImage('{{ $image }}')">
                                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-32 object-cover"
                                            alt="Gallery Image">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="closeGallery()">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentTarget = null;

        function openGallery(target) {
            currentTarget = target;
            document.getElementById('galleryModal').classList.remove('hidden');
        }

        function closeGallery() {
            document.getElementById('galleryModal').classList.add('hidden');
            currentTarget = null;
        }

        function selectImage(path) {
            if (!currentTarget) return;

            // Update hidden input
            document.getElementById(currentTarget + '_image_existing').value = path;
            
            // Update preview
            document.getElementById(currentTarget + '_preview').src = "{{ asset('storage') }}/" + path;
            
            closeGallery();
        }

        // AJAX File Upload
        async function uploadFile(input, target) {
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            // Show loading state (optional, could add a spinner)
            const preview = document.getElementById(target + '_preview');
            const originalSrc = preview.src;
            preview.style.opacity = '0.5';

            try {
                const response = await fetch('{{ route("admin.home.upload") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Update preview with the URL returned by server
                    preview.src = data.url;
                    preview.style.opacity = '1';
                    
                    // Update the hidden input with the PATH
                    document.getElementById(target + '_image_existing').value = data.path;

                    // Clear file input so change event can fire again if needed
                    input.value = '';

                    // Optional: Show success toast
                    alert('Imagen subida correctamente. No olvides guardar los cambios.');
                } else {
                    throw new Error('Upload failed');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al subir la imagen. Inténtalo de nuevo.');
                preview.src = originalSrc;
                preview.style.opacity = '1';
                input.value = '';
            }
        }

        // Add event listeners
        document.getElementById('hero_image').addEventListener('change', function() {
            uploadFile(this, 'hero');
        });

        document.getElementById('featured_image').addEventListener('change', function() {
            uploadFile(this, 'featured');
        });
    </script>
</x-app-layout>
```