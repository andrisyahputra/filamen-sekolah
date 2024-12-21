<x-filament::page>
    <div class="space-y-6">
        {{-- Laporan Sekolah Section --}}

        {{-- Laporan Sekolah Section --}}
        @if (Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('bendahara_sekolah'))
            <div class="w-full flex flex-col gap-6 p-6 rounded-lg shadow-sm">
                <h2 class="text-xl font-semibold text-gray-800">Laporan Sekolah</h2>
                <form wire:submit.prevent="create_print_sekolah" class="lg:w-[50%] w-full">
                    {{ $this->form }}
                    <div class="mt-6">
                        <button type="button"
                            onclick="confirmAction('{{ route('laporan.print_sekolah', ['bulan' => $this->bulan]) }}', '{{ route('laporan.print_sekolah', ['bulan' => $this->bulan]) }}')"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ __('Cetak Laporan Sekolah') }}
                        </button>
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
                        <button type="button"
                            onclick="confirmAction('{{ route('laporan.print_danabos', ['bulan' => $this->bulan]) }}', '{{ route('laporan.print_danabos', ['bulan' => $this->bulan]) }}')"
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
                        <button type="button"
                            onclick="confirmAction('{{ route('laporan.print_bkm', ['bulan' => $this->bulan]) }}', '{{ route('laporan.print_bkm', ['bulan' => $this->bulan]) }}')"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ __('Cetak Laporan BKM') }}

                            </a>
                    </div>
                </form>
            </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmAction(viewUrl, verifUrl) {
            Swal.fire({
                title: 'Cetak Laporan?',
                text: "Pilih tindakan untuk mencetak laporan ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6', // Warna tombol "Verif"
                cancelButtonColor: '#d33', // Warna tombol "Lihat"
                confirmButtonText: 'Verif',
                cancelButtonText: 'Lihat'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Verifikasi: buka URL untuk Verif
                    window.open(verifUrl, '_blank');
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Lihat: buka URL untuk Lihat
                    window.open(viewUrl, '_blank');
                }
            });
        }
    </script>
</x-filament::page>
