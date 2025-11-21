<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-primary-900">Gestión de Categorías</h2>
            <a href="{{ route('categories.create') }}" class="btn-primary">+ Añadir Categoría</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($message = Session::get('success'))
                <x-alert type="success" class="mb-6" dismissible>{{ $message }}</x-alert>
            @endif

            <div class="card">
                <div class="mb-6 pb-6 border-b border-primary-200">
                    <h3 class="text-xl font-bold text-primary-900">Todas las Categorías</h3>
                    <p class="text-sm text-primary-600 mt-1">Organizar libros por categoría</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Cantidad de Libros</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="font-semibold text-primary-900">{{ $category->name }}</td>
                                    <td class="text-primary-700 max-w-xs truncate">{{ $category->description ?? '—' }}</td>
                                    <td><x-badge type="info">{{ $category->books->count() }}</x-badge></td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('categories.edit', $category->id) }}" class="link-button text-xs">Editar</a>
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="link-button-danger text-xs">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-primary-500">Sin categorías aún</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
