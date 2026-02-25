<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Data Inspeksi QC
            </h2>
            @if(auth()->user()->isQCInspector() || auth()->user()->isAdmin())
            <a href="{{ route('qc-inspections.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
                + Inspeksi Baru
            </a>
            @endif
        </div>
    </x-slot>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-6 border-b">
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-800">Total Lolos</h3>
                    <p class="text-2xl font-bold">{{ $totalLolos ?? 0 }}</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-red-800">Total Gagal</h3>
                    <p class="text-2xl font-bold">{{ $totalGagal ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold mb-4">Total Lolos per Item</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($totalsPerPart as $total)
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="text-md font-semibold text-blue-800">{{ $total->part_name }} ({{ $total->part_code }})</h4>
                    <p class="text-xl font-bold">{{ $total->total_lolos }}</p>
                </div>
                @empty
                <p class="text-sm text-gray-500">Belum ada data total lolos per item</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Part</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Operator</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hasil</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lolos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gagal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Kerusakan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Inspector</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($inspections as $inspection)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $inspection->created_at->format('d/m/Y (H:i)') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $inspection->production->part->name }}</div>
                            <div class="text-xs text-gray-500">{{ $inspection->production->part->code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $inspection->production->operator->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($inspection->result == 'lolos') bg-green-100 text-green-800 
                                @elseif($inspection->result == 'gagal') bg-red-100 text-red-800 
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ strtoupper($inspection->result) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $inspection->passed_quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $inspection->failed_quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $inspection->damage_type ? str_replace('_', ' ', ucfirst($inspection->damage_type)) : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $inspection->inspector->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('qc-inspections.show', $inspection) }}" class="text-indigo-600 hover:text-indigo-900">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada data inspeksi QC
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $inspections->links() }}
        </div>
    </div>
</x-app-layout>