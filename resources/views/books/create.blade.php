<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">
            Crear Nuevo Libro
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card
                title="Información del Libro"
                description="Añadir un nuevo libro al catálogo de la biblioteca"
                icon='<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm5-3a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>'
            >
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Title & ISBN Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div>
                            <x-input-label for="title" value="Título" />
                            <x-text-input
                                id="title"
                                name="title"
                                type="text"
                                required
                                autofocus
                                placeholder="Ingresa el título del libro"
                            />
                            <x-input-error :messages="$errors->get('title')" />
                        </div>

                        <!-- ISBN with Search -->
                        <div>
                            <x-input-label for="isbn" value="ISBN" />
                            <div class="flex gap-2">
                                <x-text-input
                                    id="isbn"
                                    name="isbn"
                                    type="text"
                                    placeholder="e.g., 978-3-16-148410-0"
                                    class="flex-1"
                                />
                                <button type="button" onclick="searchBook()" class="btn-secondary" id="search-btn">
                                    Buscar
                                </button>
                            </div>
                            <p id="search-status" class="text-sm mt-2 hidden"></p>
                            <x-input-error :messages="$errors->get('isbn')" />
                        </div>
                    </div>

                    <!-- Author & Category Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Author -->
                        <div>
                            <x-input-label for="author_id" value="Autor" />
                            <select
                                id="author_id"
                                name="author_id"
                                class="input-base"
                                required
                            >
                                <option value="">Selecciona un autor...</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" @selected(old('author_id') == $author->id)>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('author_id')" />
                        </div>

                        <!-- Category -->
                        <div>
                            <x-input-label for="category_id" value="Categoría" />
                            <select
                                id="category_id"
                                name="category_id"
                                class="input-base"
                                required
                            >
                                <option value="">Selecciona una categoría...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" />
                        </div>
                    </div>

                    <!-- Published Year & Stock Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Published Year -->
                        <div>
                            <x-input-label for="published_year" value="Año de Publicación" />
                            <x-text-input
                                id="published_year"
                                name="published_year"
                                type="number"
                                min="1000"
                                max="{{ now()->year }}"
                                placeholder="{{ now()->year }}"
                            />
                            <x-input-error :messages="$errors->get('published_year')" />
                        </div>

                        <!-- Stock -->
                        <div>
                            <x-input-label for="stock" value="Stock Inicial" />
                            <x-text-input
                                id="stock"
                                name="stock"
                                type="number"
                                min="0"
                                value="1"
                                required
                            />
                            <x-input-error :messages="$errors->get('stock')" />
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <x-input-label for="cover_image" value="Imagen de Portada" />
                        <div class="mt-2">
                            <input
                                type="file"
                                id="cover_image"
                                name="cover_image"
                                accept="image/*"
                                class="block w-full text-sm text-primary-500
                                    file:mr-4 file:py-2 file:px-4 file:rounded-lg
                                    file:border-0 file:text-sm file:font-semibold
                                    file:bg-accent-100 file:text-accent-600
                                    hover:file:bg-accent-200 file:cursor-pointer
                                    transition-colors"
                            />
                            <p class="text-xs text-primary-500 mt-2">PNG, JPG o GIF (máx. 5MB)</p>
                        </div>
                        <x-input-error :messages="$errors->get('cover_image')" />
                    </div>

                    <!-- Description (if needed - optional) -->
                    <div>
                        <x-input-label for="description" value="Descripción (Opcional)" />
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="input-base"
                            placeholder="Ingresa la descripción del libro..."
                        ></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('books.index') }}" class="btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            Crear Libro
                        </button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>

    <script>
        function searchBook() {
            const isbn = document.getElementById('isbn').value;
            const status = document.getElementById('search-status');
            const btn = document.getElementById('search-btn');

            if (!isbn) {
                showStatus('Por favor, ingresa un ISBN', 'danger');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Buscando...';
            showStatus('Buscando...', 'info');

            fetch(`/api/external/book?isbn=${encodeURIComponent(isbn)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Libro no encontrado');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        showStatus(data.error, 'warning');
                        return;
                    }

                    document.getElementById('title').value = data.title || '';
                    document.getElementById('published_year').value = data.published_year || '';

                    // Handle Author
                    if (data.author) {
                        handleDropdown('author_id', data.author, '/api/authors/find-or-create');
                    }

                    // Handle Category
                    if (data.category) {
                        handleDropdown('category_id', data.category, '/api/categories/find-or-create');
                    }

                    showStatus('¡Libro encontrado! Detalles cargados.', 'success');
                })
                .catch(error => {
                    showStatus('Error al buscar el libro. Por favor, verifica el ISBN.', 'danger');
                    console.error('Error:', error);
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = 'Buscar';
                });
        }

        function handleDropdown(elementId, name, createUrl) {
            const select = document.getElementById(elementId);
            let found = false;

            // Try to find existing option
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].text.toLowerCase() === name.toLowerCase()) {
                    select.selectedIndex = i;
                    found = true;
                    break;
                }
            }

            // If not found, create it
            if (!found) {
                fetch(createUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ name: name })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.id) {
                        const option = new Option(data.name, data.id);
                        select.add(option);
                        select.value = data.id;
                        console.log(`Created and selected: ${data.name}`);
                    }
                })
                .catch(err => console.error('Error creating record:', err));
            }
        }

        function showStatus(message, type) {
            const status = document.getElementById('search-status');
            const typeClasses = {
                'success': 'text-green-600',
                'danger': 'text-red-600',
                'warning': 'text-yellow-600',
                'info': 'text-blue-600'
            };
            
            // Reset classes
            status.className = 'text-sm mt-2';
            status.classList.add(typeClasses[type] || 'text-gray-600');
            status.textContent = message;
            status.classList.remove('hidden');
        }
    </script>
</x-app-layout>
