<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">
            Panel de Administrador
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-label text-primary-600">Total de Libros</p>
                            <p class="text-4xl font-bold text-primary-900 mt-2">{{ $totalBooks }}</p>
                        </div>
                        <div class="p-3 bg-accent-100 rounded-lg">
                            <svg class="w-6 h-6 text-accent-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path><path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm5-3a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-label text-primary-600">Total de Estudiantes</p>
                            <p class="text-4xl font-bold text-primary-900 mt-2">{{ $totalUsers }}</p>
                        </div>
                        <div class="p-3 bg-accent-100 rounded-lg">
                            <svg class="w-6 h-6 text-accent-600" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-label text-primary-600">Préstamos Activos</p>
                            <p class="text-4xl font-bold text-accent-600 mt-2">{{ $activeLoans }}</p>
                        </div>
                        <div class="p-3 bg-accent-100 rounded-lg">
                            <svg class="w-6 h-6 text-accent-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011-1h8a1 1 0 011 1v1h1a1 1 0 110 2v1h1a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h1V4a1 1 0 110-2h1V2zM7 5h6v1H7V5z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>


                <div class="card border-danger-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-label text-danger-600">Préstamos Vencidos</p>
                            <p class="text-4xl font-bold text-danger-600 mt-2">{{ $overdueLoans }}</p>
                        </div>
                        <div class="p-3 bg-danger-100 rounded-lg">
                            <svg class="w-6 h-6 text-danger-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="border-b border-primary-200 pb-4 mb-6">
                    <h3 class="text-xl font-bold text-primary-900">Préstamos Recientes</h3>
                    <p class="text-sm text-primary-600 mt-1">Actividad de préstamos más reciente del sistema</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Libro</th>
                                <th>Fecha de Préstamo</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLoans as $loan)
                                <tr class="hover:bg-primary-50 transition-colors">
                                    <td class="font-semibold text-primary-900">{{ $loan->user->name }}</td>
                                    <td class="text-primary-700">{{ $loan->book->title }}</td>
                                    <td class="text-primary-600">
                                        <span class="font-mono text-sm">{{ $loan->loan_date }}</span>
                                    </td>
                                    <td>
                                        @if($loan->status == 'borrowed')
                                            <x-badge type="warning" dot>Prestado</x-badge>
                                        @else
                                            <x-badge type="success" dot>Devuelto</x-badge>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('loans.index') }}" class="link-button text-xs">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8">
                                        <p class="text-primary-500">No se encontraron préstamos recientes</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 pt-6 border-t border-primary-200">
                    <a href="{{ route('loans.index') }}" class="btn-ghost text-sm">
                        Ver Todos los Préstamos →
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
