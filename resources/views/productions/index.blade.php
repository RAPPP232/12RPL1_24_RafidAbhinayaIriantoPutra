<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Data Produksi
            </h2>
            @if(auth()->user()->isOperator() || auth()->user()->isAdmin())
            <a href="{{ route('productions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                + Input Produksi
            </a>
            @endif
        </div>
    </x-slot>

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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">QC</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($productions as $production)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $production->created_at->format('d/m/Y (H:i)') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $production->part->name }}</div>
                            <div class="text-xs text-gray-500">{{ $production->part->code }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $production->operator->name ?? '-' }}</td>
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
                                $labels = [
                                    'pending' => 'Pending',
                                    'in_progress' => 'Proses',
                                    'completed' => 'Selesai',
                                    'rejected' => 'Ditolak'
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $colors[$production->status] }}">
                                {{ $labels[$production->status] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($production->qcInspection)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $production->qcInspection->result == 'lolos' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($production->qcInspection->result) }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">Belum QC</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('productions.show', $production) }}" class="text-indigo-600 hover:text-indigo-900">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada data produksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t">
            {{ $productions->links() }}
        </div>
    </div>
</x-app-layout>