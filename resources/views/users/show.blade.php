<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/users/show/{{ $user->name }}" title="Detail Pengguna">
            <x-slot name="actions">
                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Edit
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $user->role }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-end space-x-2">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 rounded-md border border-gray-200 text-gray-700">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
