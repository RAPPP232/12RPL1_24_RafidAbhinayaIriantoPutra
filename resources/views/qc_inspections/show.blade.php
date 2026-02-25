<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('qc-inspections.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Detail Inspeksi QC #{{ $qcInspection->id }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- QC Result -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 {{ $qcInspection->result == 'lolos' ? 'bg-green-500' : 'bg-red-500' }}">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Hasil Inspeksi QC</h3>
                    <span class="px-4 py-2 bg-white rounded-full text-lg font-bold {{ $qcInspection->result == 'lolos' ? 'text-green-600' : 'text-red-600' }}">
                        {{ strtoupper($qcInspection->result) }}
                    </span>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Inspector</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $qcInspection->inspector->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Inspeksi</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $qcInspection->created_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>

                @if($qcInspection->damage_type)
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500 mb-2">Jenis Kerusakan</p>
                    <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full font-medium">
                        {{ str_replace('_', ' ', ucfirst($qcInspection->damage_type)) }}
                    </span>
                </div>
                @endif

                @if($qcInspection->notes)
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500 mb-2">Catatan</p>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900">{{ $qcInspection->notes }}</p>
                    </div>
                </div>
                @endif

                @if($qcInspection->recommendation)
                <div class="border-t pt-4">
                    <p class="text-sm text-gray-500 mb-2">Rekomendasi Perbaikan</p>
                    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                        <p class="text-gray-900">{{ $qcInspection->recommendation }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Production Info -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Produksi</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Produksi</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $qcInspection->production->production_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jumlah</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($qcInspection->production->quantity) }} pcs</p>
                    </div>
                </div>

                <div class="border-t pt-4 grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Part</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $qcInspection->production->part->name }}</p>
                        <p class="text-sm text-gray-600">Kode: {{ $qcInspection->production->part->code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Operator</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $qcInspection->production->operator->name }}</p>
                        <p class="text-sm text-gray-600">{{ $qcInspection->production->operator->code }}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <a href="{{ route('productions.show', $qcInspection->production) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                        Lihat Detail Produksi
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>