<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-primary-900">
                Gestión de Libros
            </h2>
            <a href="{{ route('books.create') }}" class="btn-ghost">
                + Añadir Nuevo Libro
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($message = Session::get('success'))
                <x-alert type="success" class="mb-6" dismissible>
                    {{ $message }}
                </x-alert>
            @endif


            <div class="card">
                <div class="mb-6 pb-6 border-b border-primary-200">
                    <h3 class="text-xl font-bold text-primary-900">Todos los Libros</h3>
                    <p class="text-sm text-primary-600 mt-1">Gestionar catálogo de libros de la biblioteca</p>
                </div>


                <div class="overflow-x-auto">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>Portada</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Categoría</th>
                                <th>ISBN</th>
                                <th>Stock</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr>

                                    <td class="w-12">
                                        @if($book->cover_image)
                                            <div class="rounded border border-primary-100 overflow-hidden h-12 bg-primary-50">
                                                <img
                                                    src="{{ asset('storage/' . $book->cover_image) }}"
                                                    alt="{{ $book->title }}"
                                                    class="h-12 w-full object-cover"
                                                >
                                            </div>
                                        @else
                                            <div class="rounded border border-primary-100 overflow-hidden h-12 bg-primary-100 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-primary-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path></svg>
                                            </div>
                                        @endif
                                    </td>


                                    <td class="font-semibold text-primary-900">{{ $book->title }}</td>


                                    <td class="text-primary-700">{{ $book->author->name ?? 'Autor Desconocido' }}</td>


                                    <td class="text-primary-700">{{ $book->category->name ?? 'Sin Categoría' }}</td>


                                    <td class="text-primary-600 font-mono text-sm">{{ $book->isbn ?? '—' }}</td>


                                    <td>
                                        @if($book->stock > 0)
                                            <x-badge type="success">{{ $book->stock }} en stock</x-badge>
                                        @else
                                            <x-badge type="danger">Agotado</x-badge>
                                        @endif
                                    </td>


                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('books.edit', $book->id) }}" class="link-button text-xs">Editar</a>
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este libro?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="link-button-danger text-xs">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8">
                                        <svg class="w-12 h-12 text-primary-300 mx-auto mb-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm5-3a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-primary-500">Aún no hay libros en el catálogo</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
