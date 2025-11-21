<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">Editar Categoría</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card title="Actualizar Información de la Categoría" description="Modificar detalles de la categoría">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" value="Nombre" />
                        <x-text-input id="name" name="name" type="text" required :value="old('name', $category->name)" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Descripción" />
                        <textarea id="description" name="description" rows="4" class="input-base" placeholder="Descripción de la categoría...">{{ old('description', $category->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('categories.index') }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary">Actualizar Categoría</button>
                    </div>
                </form>

                <div class="mt-8 pt-8 border-t border-primary-200">
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Eliminar Categoría</button>
                    </form>
                </div>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
