<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">
            Gestión de Préstamos
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Alert -->
            @if(session('success'))
                <x-alert type="success" class="mb-6">
                    {{ session('success') }}
                </x-alert>
            @endif

            <!-- Loans Table Card -->
            <div class="card">
                <div class="flex items-center justify-between mb-6 pb-6 border-b border-primary-200">
                    <div>
                        <h3 class="text-xl font-bold text-primary-900">Todos los Préstamos</h3>
                        <p class="text-sm text-primary-600 mt-1">Gestionar préstamos y devoluciones de libros de estudiantes</p>
                    </div>
                    <a href="{{ route('loans.create') }}" class="btn-primary">
                        + Nuevo Préstamo
                    </a>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Estudiante</th>
                                <th>Libro</th>
                                <th>Fecha de Préstamo</th>
                                <th>Fecha de Vencimiento</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr>
                                    <td class="text-primary-600 font-mono text-sm">#{{ $loan->id }}</td>
                                    <td class="font-semibold text-primary-900">{{ $loan->user->name }}</td>
                                    <td class="text-primary-700">{{ $loan->book->title }}</td>
                                    <td class="text-primary-600 font-mono text-sm">{{ \Carbon\Carbon::parse($loan->loan_date)->format('M d, Y') }}</td>
                                    <td class="text-primary-600 font-mono text-sm">{{ \Carbon\Carbon::parse($loan->due_date)->format('M d, Y') }}</td>
                                    <td>
                                        @if($loan->status == 'borrowed')
                                            <x-badge type="warning" dot>Prestado</x-badge>
                                        @elseif($loan->status == 'requested')
                                            <x-badge type="info" dot>Solicitado</x-badge>
                                        @elseif($loan->status == 'return_requested')
                                            <x-badge type="purple" dot>Devolución Pendiente</x-badge>
                                        @else
                                            <x-badge type="success" dot>Devuelto</x-badge>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($loan->status == 'requested')
                                                <form action="{{ route('loans.approve', $loan->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="link-button text-xs hover:underline">Aprobar</button>
                                                </form>
                                            @endif
                                            @if($loan->status == 'borrowed' || $loan->status == 'return_requested')
                                                <form action="{{ route('loans.update', $loan->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="link-button text-xs hover:underline">
                                                        {{ $loan->status == 'return_requested' ? 'Confirmar Devolución' : 'Devolver' }}
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este préstamo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="link-button-danger text-xs hover:underline">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8">
                                        <p class="text-primary-500">No se encontraron préstamos</p>
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
