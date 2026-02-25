<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl sm:text-2xl text-gray-800 leading-tight">
            Laporan Produksi & QC
        </h2>
    </x-slot>

    <div class="space-y-4 sm:space-y-6">
        <!-- Filter & Export Section -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('reports.index') }}" class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" 
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm sm:text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ $endDate }}"
                            class="w-full px-3 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm sm:text-base">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 sm:flex-none px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-md transition text-sm sm:text-base">
                            <span class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Filter
                            </span>
                        </button>
                    </div>
                </form>
                
                <!-- Export PDF Button -->
                <form method="GET" action="{{ route('reports.export-pdf') }}" class="w-full lg:w-auto">
                    <input type="hidden" name="start_date" value="{{ $startDate }}">
                    <input type="hidden" name="end_date" value="{{ $endDate }}">
                    <button type="submit" class="w-full lg:w-auto px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium shadow-md transition text-sm sm:text-base">
                        <span class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export PDF
                        </span>
                    </button>
                </form>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Periode:</span> 
                    {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
                </p>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 sm:gap-4">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm opacity-90 font-medium">Total Produksi</p>
                <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['total_productions'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm opacity-90 font-medium">Total Quantity</p>
                <p class="text-2xl sm:text-3xl font-bold mt-1">{{ number_format($stats['total_quantity']) }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm opacity-90 font-medium">QC Lolos</p>
                <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['total_lolos'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm opacity-90 font-medium">QC Partial</p>
                <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['total_partial'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm opacity-90 font-medium">QC Gagal</p>
                <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['total_gagal'] }}</p>
            </div>

            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <p class="text-xs sm:text-sm opacity-90 font-medium">Success Rate</p>
                <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['percentage_lolos'] }}%</p>
            </div>
        </div>

        <!-- Analysis Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Part Analysis -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="text-base sm:text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Analisis per Part
                    </h3>
                </div>
                <div class="p-4 sm:p-6 max-h-96 overflow-y-auto">
                    @forelse($partAnalysis as $item)
                    <div class="mb-4 pb-4 border-b last:border-b-0">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item['part_name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $item['part_code'] }}</p>
                            </div>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                {{ number_format($item['total_quantity']) }} pcs
                            </span>
                        </div>
                        <div class="flex gap-4 text-sm">
                            <span class="text-green-600">✓ {{ $item['lolos'] }} Lolos</span>
                            <span class="text-yellow-600">~ {{ $item['partial'] }} Partial</span>
                            <span class="text-red-600">✗ {{ $item['gagal'] }} Gagal</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Operator Analysis -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
                    <h3 class="text-base sm:text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Analisis per Operator
                    </h3>
                </div>
                <div class="p-4 sm:p-6 max-h-96 overflow-y-auto">
                    @forelse($operatorAnalysis as $item)
                    <div class="mb-4 pb-4 border-b last:border-b-0">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item['operator_name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $item['operator_code'] }}</p>
                            </div>
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">
                                {{ $item['total_productions'] }} produksi
                            </span>
                        </div>
                        <div class="flex gap-4 text-sm">
                            <span class="text-gray-600">{{ number_format($item['total_quantity']) }} pcs</span>
                            <span class="text-green-600">✓ {{ $item['lolos'] }}</span>
                            <span class="text-yellow-600">~ {{ $item['partial'] }}</span>
                            <span class="text-red-600">✗ {{ $item['gagal'] }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Damage Analysis -->
        @if($damageAnalysis->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-red-500 to-red-600">
                <h3 class="text-base sm:text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Analisis Jenis Kerusakan
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($damageAnalysis as $damage)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-red-600">{{ $damage['count'] }}</p>
                        <p class="text-sm text-gray-700 mt-1">{{ $damage['type'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Detailed Production Report Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Detail Laporan Produksi</h3>
            </div>
            
            <!-- Mobile View -->
            <div class="block lg:hidden">
                @forelse($productionReport as $production)
                <div class="border-b border-gray-200 p-4">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $production->part->name }}</p>
                            <p class="text-xs text-gray-500">{{ $production->part->code }}</p>
                        </div>
                        @php
                            $colors = [
                                'pending' => 'bg-gray-100 text-gray-800',
                                'in_progress' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $colors[$production->status] }}">
                            {{ ucfirst($production->status) }}
                        </span>
                    </div>
                    <div class="space-y-1 text-xs text-gray-600">
                        <p><span class="font-medium">Tanggal:</span> {{ $production->created_at->format('d/m/Y (H:i)') }}</p>
                        <p><span class="font-medium">Operator:</span> {{ $production->operator->name }}</p>
                        <p><span class="font-medium">Quantity:</span> {{ number_format($production->quantity) }} pcs</p>
                        <p>
                            <span class="font-medium">QC:</span>
                            @if($production->qcInspection)
                                <span class="px-2 py-0.5 text-xs rounded-full {{ $production->qcInspection->result == 'lolos' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ strtoupper($production->qcInspection->result) }}
                                </span>
                            @else
                                <span class="text-gray-400">Belum QC</span>
                            @endif
                        </p>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-sm text-gray-500">Tidak ada data untuk periode ini</div>
                @endforelse
            </div>

            <!-- Desktop View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Part</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Operator</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">QC</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($productionReport as $production)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $production->created_at->format('d/m/Y (H:i)') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium">{{ $production->part->name }}</div>
                                <div class="text-xs text-gray-500">{{ $production->part->code }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $production->operator->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                {{ number_format($production->quantity) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $colors = [
                                        'pending' => 'bg-gray-100 text-gray-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $colors[$production->status] }}">
                                    {{ ucfirst($production->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($production->qcInspection)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $production->qcInspection->result == 'lolos' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ strtoupper($production->qcInspection->result) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Tidak ada data untuk periode ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>