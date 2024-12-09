<x-filament::page>
    <div class="w-full flex flex-col gap-10 justify-center items-center">
        <form wire:submit.prevent="create" class="lg:w-[50%] w-full">
            {{ $this->form }}
            <a href="{{ route('laporan.print', ['bulan' => $this->bulan]) }}" target="_blank"
                class="mt-6 inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-500 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                {{ __('Cetak Laporan') }}
            </a>
        </form>
    </div>
</x-filament::page>
