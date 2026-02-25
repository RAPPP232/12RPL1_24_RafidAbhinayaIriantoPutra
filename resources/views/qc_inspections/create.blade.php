<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('qc-inspections.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Inspeksi QC Baru
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        @if($productions->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <p class="text-yellow-800 font-medium">Tidak ada produksi yang siap untuk diinspeksi</p>
                    <p class="text-yellow-700 text-sm mt-1">Semua produksi sudah diinspeksi atau belum ada produksi yang selesai</p>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('qc-inspections.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Produksi <span class="text-red-500">*</span></label>
                        <select name="production_id" id="production_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('production_id') border-red-500 @enderror">
                            <option value="">-- Pilih Produksi --</option>
                            @foreach($productions as $production)
                                <option value="{{ $production->id }}" data-quantity="{{ $production->quantity }}" {{ old('production_id') == $production->id ? 'selected' : '' }}>
                                    {{ $production->production_date->format('d/m/Y') }} - [{{ $production->part->code }}] {{ $production->part->name }} - {{ $production->operator->name }} ({{ number_format($production->quantity) }} pcs)
                                </option>
                            @endforeach
                        </select>
                        @error('production_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Lolos <span class="text-red-500">*</span></label>
                        <input type="number" name="passed_quantity" id="passed_quantity" min="0" value="{{ old('passed_quantity', 0) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('passed_quantity') border-red-500 @enderror">
                        @error('passed_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Gagal <span class="text-red-500">*</span></label>
                        <input type="number" name="failed_quantity" id="failed_quantity" min="0" value="{{ old('failed_quantity', 0) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('failed_quantity') border-red-500 @enderror">
                        @error('failed_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p id="quantity-error" class="hidden mt-1 text-sm text-red-600">Jumlah lolos + gagal harus sama dengan kuantitas produksi</p>
                    </div>

                    <div id="damage_type_section" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kerusakan <span class="text-red-500">*</span></label>
                        <select name="damage_type" id="damage_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('damage_type') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Kerusakan --</option>
                            <option value="kerusakan_fisik" {{ old('damage_type') == 'kerusakan_fisik' ? 'selected' : '' }}>Kerusakan Fisik</option>
                            <option value="dimensi_tidak_sesuai" {{ old('damage_type') == 'dimensi_tidak_sesuai' ? 'selected' : '' }}>Dimensi Tidak Sesuai</option>
                            <option value="cacat_permukaan" {{ old('damage_type') == 'cacat_permukaan' ? 'selected' : '' }}>Cacat Permukaan</option>
                            <option value="lainnya" {{ old('damage_type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('damage_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rekomendasi Perbaikan</label>
                        <textarea name="recommendation" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('recommendation') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                        <a href="{{ route('qc-inspections.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                            Batal
                        </a>
                        <button type="submit" id="submit-btn" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-md">
                            Simpan Inspeksi
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>

    <script>
        let currentQuantity = 0;
        const productionSelect = document.getElementById('production_id');
        const passedInput = document.getElementById('passed_quantity');
        const failedInput = document.getElementById('failed_quantity');
        const damageSection = document.getElementById('damage_type_section');
        const damageSelect = document.getElementById('damage_type');
        const quantityError = document.getElementById('quantity-error');
        const submitBtn = document.getElementById('submit-btn');

        function toggleDamageType() {
            const failedQuantity = parseInt(failedInput.value) || 0;
            if (failedQuantity > 0) {
                damageSection.classList.remove('hidden');
                damageSelect.setAttribute('required', 'required');
            } else {
                damageSection.classList.add('hidden');
                damageSelect.removeAttribute('required');
                damageSelect.value = '';
            }
        }

        function updateMaxLimits() {
            const passed = parseInt(passedInput.value) || 0;
            const failed = parseInt(failedInput.value) || 0;
            passedInput.max = currentQuantity - failed;
            failedInput.max = currentQuantity - passed;
        }

        function clampValue(input, max) {
            let value = parseInt(input.value) || 0;
            if (value > max) {
                input.value = max;
            } else if (value < 0) {
                input.value = 0;
            }
        }

        function checkQuantity() {
            const passed = parseInt(passedInput.value) || 0;
            const failed = parseInt(failedInput.value) || 0;
            const total = passed + failed;
            if (currentQuantity === 0 || total !== currentQuantity) {
                quantityError.classList.remove('hidden');
                submitBtn.disabled = true;
            } else {
                quantityError.classList.add('hidden');
                submitBtn.disabled = false;
            }
            // Also check for exceeding, though clamping should prevent it
            if (total > currentQuantity) {
                quantityError.classList.remove('hidden');
                submitBtn.disabled = true;
            }
        }

        productionSelect.addEventListener('change', () => {
            currentQuantity = parseInt(productionSelect.options[productionSelect.selectedIndex].dataset.quantity) || 0;
            passedInput.value = 0;
            failedInput.value = 0;
            passedInput.max = currentQuantity;
            failedInput.max = currentQuantity;
            checkQuantity();
            toggleDamageType();
        });

        passedInput.addEventListener('input', () => {
            const failed = parseInt(failedInput.value) || 0;
            clampValue(passedInput, currentQuantity - failed);
            updateMaxLimits();
            checkQuantity();
            toggleDamageType();
        });

        failedInput.addEventListener('input', () => {
            const passed = parseInt(passedInput.value) || 0;
            clampValue(failedInput, currentQuantity - passed);
            updateMaxLimits();
            checkQuantity();
            toggleDamageType();
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (productionSelect.value !== '') {
                productionSelect.dispatchEvent(new Event('change'));
            }
            toggleDamageType();
            checkQuantity();
        });
    </script>
</x-app-layout>