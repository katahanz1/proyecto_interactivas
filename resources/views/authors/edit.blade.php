<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">Editar Autor</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card title="Actualizar Información del Autor" description="Modificar detalles del autor">
                <form action="{{ route('authors.update', $author->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" value="Nombre" />
                        <x-text-input id="name" name="name" type="text" required :value="old('name', $author->name)" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="bio" value="Biografía" />
                        <textarea id="bio" name="bio" rows="5" class="input-base" placeholder="Biografía del autor...">{{ old('bio', $author->bio) }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" />
                    </div>

                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('authors.index') }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary">Actualizar Autor</button>
                    </div>
                </form>

                <div class="mt-8 pt-8 border-t border-primary-200">
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST" onsubmit="return confirm('¿Eliminar?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Eliminar Autor</button>
                    </form>
                </div>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
