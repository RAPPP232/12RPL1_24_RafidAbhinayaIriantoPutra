<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('productions.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Detail Produksi #{{ $production->id }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Production Info -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-semibold text-white">Informasi Produksi</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Produksi</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $production->production_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        @php
                            $colors = [
                                'pending' => 'bg-gray-100 text-gray-800',
                                'in_progress' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="inline-block mt-1 px-3 py-1 text-sm font-semibold rounded-full {{ $colors[$production->status] }}">
                            {{ ucfirst($production->status) }}
                        </span>
                    </div>
                </div>

                <div class="border-t pt-4 grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Part</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $production->part->name }}</p>
                        <p class="text-sm text-gray-600">Kode: {{ $production->part->code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jumlah Produksi</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($production->quantity) }} pcs</p>
                    </div>
                </div>

                <div class="border-t pt-4 grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Operator</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $production->operator->name }}</p>
                        <p class="text-sm text-gray-600">{{ $production->operator->code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Dibuat Oleh</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $production->operator->name }}</p>
                        <p class="text-sm text-gray-600">{{ $production->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($production->notes)
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500 mb-2">Catatan</p>
                    <p class="text-gray-900">{{ $production->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- QC Inspection Info -->
        @if($production->qcInspection)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 {{ $production->qcInspection->result == 'lolos' ? 'bg-green-500' : 'bg-red-500' }}">
                <h3 class="text-lg font-semibold text-white">Hasil Inspeksi QC</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Hasil Inspeksi</p>
                        <span class="inline-block mt-1 px-3 py-1 text-sm font-semibold rounded-full {{ $production->qcInspection->result == 'lolos' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ strtoupper($production->qcInspection->result) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Inspector</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $production->qcInspection->inspector->name }}</p>
                        <p class="text-sm text-gray-600">{{ $production->qcInspection->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                @if($production->qcInspection->damage_type)
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500 mb-2">Jenis Kerusakan</p>
                    <p class="text-gray-900 font-medium">{{ str_replace('_', ' ', ucfirst($production->qcInspection->damage_type)) }}</p>
                </div>
                @endif

                @if($production->qcInspection->notes)
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500 mb-2">Catatan QC</p>
                    <p class="text-gray-900">{{ $production->qcInspection->notes }}</p>
                </div>
                @endif

                @if($production->qcInspection->recommendation)
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500 mb-2">Rekomendasi</p>
                    <p class="text-gray-900">{{ $production->qcInspection->recommendation }}</p>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="text-yellow-800 font-medium">Produksi ini belum diinspeksi oleh QC</span>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>