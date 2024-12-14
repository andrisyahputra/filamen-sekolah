<x-filament::page>
    <div class="space-y-6">
        {{-- Laporan Sekolah Section --}}

        @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('bendahara_sekolah'))
            <div class="w-full flex flex-col gap-6 p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800">Laporan Sekolah</h2>
                <form wire:submit.prevent="create_print_sekolah" class="lg:w-[50%] w-full">
                    {{ $this->form }}
                    <div class="mt-6">
                        <a href="{{ route('laporan.print_sekolah', ['bulan' => $this->bulan]) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ __('Cetak Laporan Sekolah') }}
                        </a>
                    </div>
                </form>
            </div>
        @endif

        {{-- Laporan Dana BOS Section --}}
        @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('bendahara_bkm'))
            <div class="w-full flex flex-col gap-6 p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800">Laporan Dana BOS</h2>
                <form wire:submit.prevent="create_print_danabos" class="lg:w-[50%] w-full">
                    {{ $this->form }}
                    <div class="mt-6">
                        <a href="{{ route('laporan.print_danabos', ['bulan' => $this->bulan]) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ __('Cetak Laporan Dana BOS') }}
                        </a>
                    </div>
                </form>
            </div>
        @endif

        {{-- Laporan BKM Section --}}
        @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('bendahara_dana_bos'))
            <div class="w-full flex flex-col gap-6 p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800">Laporan BKM</h2>
                <form wire:submit.prevent="create_print_bkm" class="lg:w-[50%] w-full">
                    {{ $this->form }}
                    <div class="mt-6">
                        <a href="{{ route('laporan.print_bkm', ['bulan' => $this->bulan]) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ __('Cetak Laporan BKM') }}
                        </a>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-filament::page>
