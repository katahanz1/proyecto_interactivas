<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">Añadir Nuevo Autor</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card title="Información del Autor" description="Añadir un nuevo autor al sistema">
                <form action="{{ route('authors.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nombre" />
                        <x-text-input id="name" name="name" type="text" required autofocus placeholder="Nombre del Autor" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="bio" value="Biografía" />
                        <textarea id="bio" name="bio" rows="5" class="input-base" placeholder="Biografía del autor..."></textarea>
                        <x-input-error :messages="$errors->get('bio')" />
                    </div>

                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('authors.index') }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary">Crear Autor</button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
