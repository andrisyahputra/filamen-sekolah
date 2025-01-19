<x-filament-panels::page>
    <div>
        @php
            $totalItems = count($kelas);
        @endphp
        <h1 class="text-2xl font-bold mb-6 text-center ">Daftar Kelas ({{ $totalItems }})</h1>

        @if (jumlahSiswaTanpaKelas() != 0)
            <div
                class="p-4 shadow-md rounded border-2 border-success-600 outline outline-2 outline-offset-2 outline-success-400 text-center">
                <h3 class="text-lg font-semibold">Tidak Ada kelas</h3>
                <p class="text-sm">-</p>
                <p class="text-sm">Jumlah Murid {{ jumlahSiswaTanpaKelas() }}</p>
                <a href="{{ route('filament.admin.resources.siswas.kelas', ['record' => '0']) }}" class="underline">Lihat
                    Siswa</a>
            </div>
        @endif


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-center mt-3 ">

            @foreach ($kelas as $item)
                <div
                    class="p-4 shadow-md rounded border-2 border-success-600 outline outline-2 outline-offset-2 outline-success-400 ">
                    <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                    <p class="text-sm">Wali Kelas {{ $item->guru->name ?? 'Tidak ada' }}</p>
                    <p class="text-sm">Jumlah Murid {{ $item->siswas()->count() }}</p>
                    <a href="{{ route('filament.admin.resources.siswas.kelas', ['record' => $item->id]) }}"
                        class="underline">Lihat
                        Siswa</a>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
