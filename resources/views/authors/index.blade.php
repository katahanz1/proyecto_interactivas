<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-primary-900">Authors Management</h2>
            <a href="{{ route('authors.create') }}" class="btn-primary">+ Add Author</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($message = Session::get('success'))
                <x-alert type="success" class="mb-6" dismissible>{{ $message }}</x-alert>
            @endif

            <div class="card">
                <div class="mb-6 pb-6 border-b border-primary-200">
                    <h3 class="text-xl font-bold text-primary-900">All Authors</h3>
                    <p class="text-sm text-primary-600 mt-1">Manage book authors</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Biography</th>
                                <th>Books Count</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($authors as $author)
                                <tr>
                                    <td class="font-semibold text-primary-900">{{ $author->name }}</td>
                                    <td class="text-primary-700 max-w-xs truncate">{{ $author->bio ?? '—' }}</td>
                                    <td><x-badge type="info">{{ $author->books->count() }}</x-badge></td>
                                    <td class="text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('authors.edit', $author->id) }}" class="link-button text-xs">Edit</a>
                                            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="link-button-danger text-xs">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-primary-500">No authors yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
