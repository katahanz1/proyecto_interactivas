<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">Create New Loan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card title="Loan Information" description="Create a new book loan for a student">
                <form action="{{ route('loans.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="user_id" value="Student" />
                            <select name="user_id" id="user_id" class="input-base w-full" required>
                                <option value="">Select a student...</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('user_id')" />
                        </div>

                        <div>
                            <x-input-label for="book_id" value="Book" />
                            <select name="book_id" id="book_id" class="input-base w-full" required>
                                <option value="">Select a book...</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} (Stock: {{ $book->stock }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('book_id')" />
                        </div>

                        <div>
                            <x-input-label for="loan_date" value="Loan Date" />
                            <x-text-input id="loan_date" name="loan_date" type="date" :value="date('Y-m-d')" required />
                            <x-input-error :messages="$errors->get('loan_date')" />
                        </div>

                        <div>
                            <x-input-label for="due_date" value="Due Date" />
                            <x-text-input id="due_date" name="due_date" type="date" :value="date('Y-m-d', strtotime('+7 days'))" required />
                            <x-input-error :messages="$errors->get('due_date')" />
                        </div>
                    </div>

                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('loans.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary">Create Loan</button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
