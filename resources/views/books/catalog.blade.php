<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">
            Catálogo de Libros
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <x-alert type="success" class="mb-6" dismissible>
                    {{ session('success') }}
                </x-alert>
            @endif


            @if(session('error'))
                <x-alert type="danger" class="mb-6" dismissible>
                    {{ session('error') }}
                </x-alert>
            @endif


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($books as $book)
                    <div class="card flex flex-col">

                        <div class="mb-4 -m-6 mb-4 rounded-t-lg overflow-hidden bg-primary-100 h-48">
                            @if($book->cover_image)
                                <img
                                    src="{{ asset('storage/' . $book->cover_image) }}"
                                    alt="{{ $book->title }}"
                                    class="w-full h-full object-cover"
                                >
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-primary-100 to-primary-50">
                                    <svg class="w-12 h-12 text-primary-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm5-3a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-primary-500">Sin Imagen de Portada</span>
                                </div>
                            @endif
                        </div>


                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-primary-900 mb-1 line-clamp-2">
                                {{ $book->title }}
                            </h3>

                            <p class="text-sm font-semibold text-accent-600 mb-1">
                                {{ $book->author->name ?? 'Autor Desconocido' }}
                            </p>

                            <p class="text-xs text-primary-500 uppercase tracking-wider font-semibold mb-3">
                                {{ $book->category->name ?? 'Sin Categoría' }}
                            </p>

                            <p class="text-sm text-primary-700 line-clamp-3 mb-4">
                                {{ $book->description ?? 'No hay descripción disponible.' }}
                            </p>
                        </div>


                        <div class="border-t border-primary-200 pt-4 mt-4">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    @if($book->stock > 0)
                                        <x-badge type="success" dot>
                                            {{ $book->stock }} Disponible
                                        </x-badge>
                                    @else
                                        <x-badge type="danger" dot>
                                            Agotado
                                        </x-badge>
                                    @endif
                                </div>
                            </div>

                            @if($book->stock > 0)
                                <form action="{{ route('loans.request') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button type="submit" class="btn-primary w-full">
                                        Solicitar Libro
                                    </button>
                                </form>
                            @else
                                <button disabled class="btn-secondary w-full opacity-50 cursor-not-allowed">
                                    No Disponible
                                </button>
                            @endif
                        </div>
                    </div>
                @empty

                    <div class="col-span-full">
                        <div class="card bg-primary-50 border-primary-200 text-center py-12">
                            <svg class="w-16 h-16 text-primary-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm5-3a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-primary-900 mb-2">No Hay Libros Disponibles</h3>
                            <p class="text-primary-600">El catálogo está actualmente vacío. Por favor, vuelve más tarde.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
