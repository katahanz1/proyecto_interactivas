<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">
            Editar Libro
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card
                title="Actualizar Información del Libro"
                description="Modificar detalles del libro e imagen de portada"
                icon='<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm5-3a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>'
            >
                <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                                :value="old('title', $book->title)"
                            />
                            <x-input-error :messages="$errors->get('title')" />
                        </div>

                        <!-- ISBN -->
                        <div>
                            <x-input-label for="isbn" value="ISBN" />
                            <x-text-input
                                id="isbn"
                                name="isbn"
                                type="text"
                                :value="old('isbn', $book->isbn)"
                            />
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
                                    <option value="{{ $author->id }}" @selected($book->author_id == $author->id)>
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
                                    <option value="{{ $category->id }}" @selected($book->category_id == $category->id)>
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
                                :value="old('published_year', $book->published_year)"
                            />
                            <x-input-error :messages="$errors->get('published_year')" />
                        </div>

                        <!-- Stock -->
                        <div>
                            <x-input-label for="stock" value="Stock" />
                            <x-text-input
                                id="stock"
                                name="stock"
                                type="number"
                                min="0"
                                :value="old('stock', $book->stock)"
                                required
                            />
                            <x-input-error :messages="$errors->get('stock')" />
                        </div>
                    </div>

                    <!-- Current Cover Image -->
                    @if($book->cover_image)
                        <div class="border border-primary-200 rounded-lg p-4 bg-primary-25">
                            <p class="text-sm font-semibold text-primary-900 mb-3">Imagen de Portada Actual</p>
                            <div class="rounded-lg overflow-hidden border border-primary-200 inline-block">
                                <img
                                    src="{{ asset('storage/' . $book->cover_image) }}"
                                    alt="{{ $book->title }}"
                                    class="h-32 object-cover"
                                >
                            </div>
                        </div>
                    @endif

                    <!-- Cover Image Upload -->
                    <div>
                        <x-input-label for="cover_image" value="Actualizar Imagen de Portada" />
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
                            <p class="text-xs text-primary-500 mt-2">PNG, JPG o GIF (máx. 5MB). Deja vacío para mantener la imagen actual.</p>
                        </div>
                        <x-input-error :messages="$errors->get('cover_image')" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" value="Descripción" />
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="input-base"
                            placeholder="Ingresa la descripción del libro..."
                        >{{ old('description', $book->description) }}</textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('books.index') }}" class="btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            Actualizar Libro
                        </button>
                    </div>
                </form>

                <!-- Delete Button (Separate) -->
                <div class="mt-8 pt-8 border-t border-primary-200">
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este libro?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">
                            Eliminar Libro
                        </button>
                    </form>
                </div>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
