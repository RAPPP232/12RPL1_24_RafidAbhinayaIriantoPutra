<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight">
                Data Part & Komponen
            </h2>
            <a href="{{ route('parts.create') }}" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Part
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Mobile View (Cards) -->
        <div class="block md:hidden">
            @forelse($parts as $part)
            <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex-1">
                        <p class="font-mono text-sm font-semibold text-indigo-600">{{ $part->code }}</p>
                        <h3 class="text-base font-semibold text-gray-900 mt-1">{{ $part->name }}</h3>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full ml-2">
                        {{ $part->productions_count }} kali
                    </span>
                </div>
                @if($part->description)
                <p class="text-sm text-gray-600 mb-3">{{ Str::limit($part->description, 80) }}</p>
                @endif
                <div class="flex gap-2">
                    <a href="{{ route('parts.edit', $part) }}" class="flex-1 text-center px-3 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100">
                        Edit
                    </a>
                    <form action="{{ route('parts.destroy', $part) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus part ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-medium hover:bg-red-100">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-sm text-gray-500">
                Belum ada data part
            </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Part</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Produksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($parts as $part)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-semibold text-gray-900">{{ $part->code }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $part->name }}</div>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <div class="text-sm text-gray-600">{{ $part->description ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-sm font-semibold bg-blue-100 text-blue-800 rounded-full">
                                {{ $part->productions_count }} kali
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('parts.edit', $part) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form action="{{ route('parts.destroy', $part) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus part ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada data part
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $parts->links() }}
        </div>
    </div>
</x-app-layout>