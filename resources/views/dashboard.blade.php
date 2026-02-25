<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
            <h3 class="text-xl sm:text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p class="text-indigo-100 text-sm sm:text-base">
                Role: <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

            <!-- Total Produksi -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Total Produksi</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_productions'] }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Part -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Total Part</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_parts'] }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Operator -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Total Operator</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_operators'] }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-yellow-100 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Inspeksi -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Pending Inspeksi</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-2">{{ $stats['pending_inspections'] }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Productions -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Produksi Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs sm:text-sm">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-500">Tanggal</th>
                            <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-500">Part</th>
                            <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-500">Operator</th>
                            <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-500">Jumlah</th>
                            <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-500">Status</th>
                            <th class="px-4 sm:px-6 py-3 text-left font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-xs sm:text-sm">
                        @forelse($recentProductions as $production)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 sm:px-6 py-3 whitespace-nowrap">
                                {{ $production->created_at->format('d/m/Y (H:i)') }}
                            </td>

                            <td class="px-4 sm:px-6 py-3 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $production->part->name }}</div>
                                <div class="text-gray-500">{{ $production->part->code }}</div>
                            </td>

                            <td class="px-4 sm:px-6 py-3">{{ $production->operator->name }}</td>

                            <td class="px-4 sm:px-6 py-3">{{ number_format($production->quantity) }} pcs</td>

                            <td class="px-4 sm:px-6 py-3">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-gray-100 text-gray-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp

                                <span class="px-2 py-1 inline-flex text-[10px] sm:text-xs font-semibold rounded-full {{ $statusColors[$production->status] }}">
                                    {{ ucfirst(str_replace('_',' ',$production->status)) }}
                                </span>
                            </td>

                            <td class="px-4 sm:px-6 py-3 font-medium">
                                <a href="{{ route('productions.show', $production) }}" class="text-indigo-600 hover:text-indigo-900">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 sm:px-6 py-4 text-center text-gray-500">
                                Belum ada data produksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($recentProductions->count() > 0)
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-t border-gray-200">
                <a href="{{ route('productions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">
                    Lihat Semua Produksi →
                </a>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6">

            @if(auth()->user()->isOperator() || auth()->user()->isAdmin())
            <a href="{{ route('productions.create') }}" class="bg-white rounded-lg shadow-md p-4 sm:p-6 hover:shadow-lg transition border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-blue-100 rounded-full mr-4">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base sm:text-lg font-semibold text-gray-800">Input Produksi</h4>
                        <p class="text-xs sm:text-sm text-gray-600">Tambah data produksi baru</p>
                    </div>
                </div>
            </a>
            @endif

            @if(auth()->user()->isQCInspector() || auth()->user()->isAdmin())
            <a href="{{ route('qc-inspections.create') }}" class="bg-white rounded-lg shadow-md p-4 sm:p-6 hover:shadow-lg transition border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-green-100 rounded-full mr-4">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base sm:text-lg font-semibold text-gray-800">QC Inspeksi</h4>
                        <p class="text-xs sm:text-sm text-gray-600">Lakukan inspeksi QC</p>
                    </div>
                </div>
            </a>
            @endif

            {{-- @if(auth()->user()->isAdmin())
            <a href="{{ route('reports.index') }}" class="bg-white rounded-lg shadow-md p-4 sm:p-6 hover:shadow-lg transition border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-purple-100 rounded-full mr-4">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base sm:text-lg font-semibold text-gray-800">Laporan</h4>
                        <p class="text-xs sm:text-sm text-gray-600">Lihat laporan produksi</p>
                    </div>
                </div>
            </a>
            @endif --}}
        </div>
    </div>
</x-app-layout>