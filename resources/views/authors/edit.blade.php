<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">Edit Author</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card title="Update Author Information" description="Modify author details">
                <form action="{{ route('authors.update', $author->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" type="text" required :value="old('name', $author->name)" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="bio" value="Biography" />
                        <textarea id="bio" name="bio" rows="5" class="input-base" placeholder="Author biography...">{{ old('bio', $author->bio) }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" />
                    </div>

                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('authors.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary">Update Author</button>
                    </div>
                </form>

                <div class="mt-8 pt-8 border-t border-primary-200">
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST" onsubmit="return confirm('Delete?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Delete Author</button>
                    </form>
                </div>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
