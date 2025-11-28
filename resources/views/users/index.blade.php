<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-primary-900">
                Gestión de Usuarios
            </h2>
            <a href="{{ route('users.create') }}" class="btn-ghost">
                + Añadir Nuevo Usuario
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

            @if($message = Session::get('error'))
                <x-alert type="danger" class="mb-6" dismissible>
                    {{ $message }}
                </x-alert>
            @endif


            <div class="card">
                <div class="mb-6 pb-6 border-b border-primary-200">
                    <h3 class="text-xl font-bold text-primary-900">Todos los Usuarios</h3>
                    <p class="text-sm text-primary-600 mt-1">Gestionar administradores y estudiantes</p>
                </div>


                <div class="overflow-x-auto">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha de Registro</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="font-semibold text-primary-900">{{ $user->name }}</td>
                                    <td class="text-primary-700">{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <x-badge type="purple">Administrador</x-badge>
                                        @else
                                            <x-badge type="info">Estudiante</x-badge>
                                        @endif
                                    </td>
                                    <td class="text-primary-600 font-mono text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="link-button-danger text-xs">Eliminar</button>
                                            </form>
                                        @else
                                            <span class="text-xs text-primary-400 italic">Tú</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-primary-500">No hay usuarios registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
