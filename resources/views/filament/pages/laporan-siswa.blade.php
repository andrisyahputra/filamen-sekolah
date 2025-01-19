<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Laporan Sekolah Section --}}

        {{-- Laporan Sekolah Section --}}
        @if (Auth::user()->hasRole('super_admin'))
            <div class="w-full flex flex-col gap-6 p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800">Laporan Sekolah</h2>
                <form wire:submit.prevent="create_print_sekolah" class="lg:w-[50%] w-full">
                    {{ $this->form }}
                    <div class="mt-6">
                        <button type="button"
                            onclick="confirmAction('{{ route('laporan.print_sekolah', ['bulan' => '$this->bulan']) }}', '{{ route('laporan.print_sekolah', ['bulan' => '$this->bulan']) }}')"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ __('Cetak Laporan Sekolah') }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

</x-filament-panels::page>
