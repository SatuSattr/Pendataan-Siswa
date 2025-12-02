<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/users/index" title="Manajemen Pengguna">
            <x-slot name="actions">
                <a href="{{ route('users.create') }}" class="btn-brand">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Pengguna
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-800">{{ $user->email }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            <span class="px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs">{{ $user->role }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-800 space-x-2">
                                            <a href="{{ route('users.show', $user) }}" class="text-indigo-600/80 hover:text-indigo-600"><i class="fa-solid fa-eye"></i></a>
                                            <a href="{{ route('users.edit', $user) }}" class="text-blue-600/80 hover:text-blue-600"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600/80 hover:text-red-600 cursor-pointer" onclick="return confirm('Hapus pengguna ini?')"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">Belum ada pengguna.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
