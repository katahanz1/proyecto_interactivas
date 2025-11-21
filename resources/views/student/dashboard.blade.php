<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">
            My Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Active Loans Section -->
            <div class="mb-8">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-primary-900">Active Loans</h3>
                    <p class="text-primary-600 text-sm mt-1">Books currently checked out</p>
                </div>

                @if($activeLoans->isEmpty())
                    <div class="card bg-primary-50 border-primary-200">
                        <div class="flex items-center gap-3 text-center">
                            <svg class="w-8 h-8 text-primary-400 flex-shrink-0 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v14a1 1 0 001 1h14a1 1 0 001-1V4a1 1 0 00-1-1h-2a1 1 0 100 2h2v12H4V5z" clip-rule="evenodd"></path></svg>
                            <p class="text-primary-700 font-semibold">You have no active loans</p>
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
                                    <p class="text-sm text-primary-600 mb-4">by {{ $loan->book->author?->name ?? 'Unknown' }}</p>

                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-primary-600">Loan Date:</span>
                                            <span class="font-mono text-primary-900">{{ \Carbon\Carbon::parse($loan->loan_date)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-primary-600">Due:</span>
                                            <span class="font-mono text-primary-900">{{ \Carbon\Carbon::parse($loan->due_date)->format('M d, Y') }}</span>
                                        </div>
                                    </div>

                                    @if(\Carbon\Carbon::parse($loan->due_date)->isPast())
                                        <x-badge type="danger" dot>Overdue</x-badge>
                                    @else
                                        <x-badge type="success" dot>
                                            {{ \Carbon\Carbon::parse($loan->due_date)->diffInDays() }} days remaining
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
                    <h3 class="text-xl font-bold text-primary-900">Loan History</h3>
                    <p class="text-sm text-primary-600 mt-1">All your past loans</p>
                </div>

                @if($loanHistory->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-primary-500">No loan history available</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="table-responsive">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Loan Date</th>
                                    <th>Return Date</th>
                                    <th>Duration</th>
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
                                                {{ \Carbon\Carbon::parse($loan->loan_date)->diffInDays(\Carbon\Carbon::parse($loan->return_date)) }} days
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
