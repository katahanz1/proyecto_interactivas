<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-primary-900">Add New Category</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-form-card title="Category Information" description="Create a new book category">
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" type="text" required autofocus placeholder="Category name" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="4" class="input-base" placeholder="Category description..."></textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>

                    <div class="flex gap-3 justify-end pt-6 border-t border-primary-200">
                        <a href="{{ route('categories.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary">Create Category</button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
</x-app-layout>
