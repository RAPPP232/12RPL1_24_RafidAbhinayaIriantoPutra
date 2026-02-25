<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('productions.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Input Data Produksi
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('productions.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Part <span class="text-red-500">*</span></label>
                        <select name="part_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('part_id') border-red-500 @enderror">
                            <option value="">-- Pilih Part --</option>
                            @foreach($parts as $part)
                                <option value="{{ $part->id }}" {{ old('part_id') == $part->id ? 'selected' : '' }}>
                                    [{{ $part->code }}] {{ $part->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('part_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Operator <span class="text-red-500">*</span></label>
                        <select name="operator_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('operator_id') border-red-500 @enderror">

                            <option value="">-- Pilih Operator --</option>

                            @foreach($operators as $operator)

                                {{-- Jika user login adalah operator, hanya tampilkan dirinya sendiri --}}
                                @if(Auth::user()->role === 'operator')
                                    @if(Auth::id() === $operator->id)
                                        <option value="{{ $operator->id }}" selected>
                                            {{ $operator->name }}
                                        </option>
                                    @endif

                                {{-- Jika user login bukan operator, tampilkan semua operator --}}
                                @else
                                    <option value="{{ $operator->id }}" {{ old('operator_id') == $operator->id ? 'selected' : '' }}>
                                        {{ $operator->name }}
                                    </option>
                                @endif

                            @endforeach
                        </select>
                        @error('operator_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Produksi <span class="text-red-500">*</span></label>
                            <input type="date" name="production_date" value="{{ old('production_date', date('Y-m-d')) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('production_date') border-red-500 @enderror">
                            @error('production_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (pcs) <span class="text-red-500">*</span></label>
                            <input type="number" name="quantity" value="{{ old('quantity') }}" min="1" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('quantity') border-red-500 @enderror">
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                        <a href="{{ route('productions.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-md">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>