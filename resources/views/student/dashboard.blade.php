<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">
            Mi Panel de Control
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Active Loans Section -->
            <div class="mb-8">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-primary-900">Préstamos Activos</h3>
                    <p class="text-primary-600 text-sm mt-1">Libros actualmente prestados</p>
                </div>

                @if($activeLoans->isEmpty())
                    <div class="card bg-primary-50 border-primary-200">
                        <div class="flex items-center gap-3 text-center">
                            <svg class="w-8 h-8 text-primary-400 flex-shrink-0 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v14a1 1 0 001 1h14a1 1 0 001-1V4a1 1 0 00-1-1h-2a1 1 0 100 2h2v12H4V5z" clip-rule="evenodd"></path></svg>
                            <p class="text-primary-700 font-semibold">No tienes préstamos activos</p>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($activeLoans as $loan)
                            <div class="card relative overflow-hidden">
                                <!-- Status Indicator -->
                                <div class="absolute top-0 right-0 w-2 h-full {{ \Carbon\Carbon::parse($loan->due_date)->isPast() ? 'bg-danger-600' : 'bg-success-600' }}"></div>

                                <div>
                                    <h4 class="font-bold text-lg text-primary-900 mb-1 pr-4">{{ $loan->book->title }}</h4>
                                    <p class="text-sm text-primary-600 mb-4">por {{ $loan->book->author?->name ?? 'Desconocido' }}</p>

                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-primary-600">Fecha de Préstamo:</span>
                                            <span class="font-mono text-primary-900">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M, Y') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-primary-600">Vencimiento:</span>
                                            <span class="font-mono text-primary-900">{{ \Carbon\Carbon::parse($loan->due_date)->format('d M, Y') }}</span>
                                        </div>
                                    </div>

                                    @if(\Carbon\Carbon::parse($loan->due_date)->isPast())
                                        <x-badge type="danger" dot>Vencido</x-badge>
                                    @else
                                        <x-badge type="success" dot>
                                            {{ \Carbon\Carbon::parse($loan->due_date)->diffInDays() }} días restantes
                                        </x-badge>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Loan History Section -->
            <div class="card">
                <div class="border-b border-primary-200 pb-4 mb-6">
                    <h3 class="text-xl font-bold text-primary-900">Historial de Préstamos</h3>
                    <p class="text-sm text-primary-600 mt-1">Todos tus préstamos anteriores</p>
                </div>

                @if($loanHistory->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-primary-500">Sin historial de préstamos disponible</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="table-responsive">
                            <thead>
                                <tr>
                                    <th>Título del Libro</th>
                                    <th>Fecha de Préstamo</th>
                                    <th>Fecha de Devolución</th>
                                    <th>Duración</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loanHistory as $loan)
                                    <tr>
                                        <td class="font-semibold text-primary-900">{{ $loan->book->title }}</td>
                                        <td class="text-primary-700">
                                            <span class="font-mono text-sm">{{ \Carbon\Carbon::parse($loan->loan_date)->format('M d, Y') }}</span>
                                        </td>
                                        <td class="text-primary-700">
                                            <span class="font-mono text-sm">
                                                @if($loan->return_date)
                                                    {{ \Carbon\Carbon::parse($loan->return_date)->format('M d, Y') }}
                                                @else
                                                    <span class="text-primary-400">—</span>
                                                @endif
                                            </span>
                                        </td>
                                        <td class="text-primary-600">
                                            @if($loan->return_date)
                                                {{ \Carbon\Carbon::parse($loan->loan_date)->diffInDays(\Carbon\Carbon::parse($loan->return_date)) }} días
                                            @else
                                                <span class="text-primary-400">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
