<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">Añadir Nueva Categoría</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card title="Información de la Categoría" description="Crear una nueva categoría de libros">
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nombre" />
                        <x-text-input id="name" name="name" type="text" required autofocus placeholder="Nombre de la Categoría" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Descripción" />
                        <textarea id="description" name="description" rows="4" class="input-base" placeholder="Descripción de la categoría..."></textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('categories.index') }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary">Crear Categoría</button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
