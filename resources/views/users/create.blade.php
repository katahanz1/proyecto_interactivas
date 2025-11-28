<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-primary-900">
                Añadir Nuevo Usuario
            </h2>
            <a href="{{ route('users.index') }}" class="link-button">
                &larr; Volver a Usuarios
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card">
                <div class="mb-6 pb-6 border-b border-primary-200">
                    <h3 class="text-xl font-bold text-primary-900">Información del Usuario</h3>
                    <p class="text-sm text-primary-600 mt-1">Ingresa los datos del nuevo usuario</p>
                </div>

                <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                    @csrf


                    <div>
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>


                    <div>
                        <x-input-label for="email" :value="__('Correo Electrónico')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>


                    <div>
                        <x-input-label for="role" :value="__('Rol')" />
                        <select id="role" name="role" class="input-base mt-1 block w-full">
                            <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>


                    <div>
                        <x-input-label for="password" :value="__('Contraseña')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>


                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-ghost">
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
