<x-filament-panels::page>
    <div>
        <h1 class="text-2xl font-bold mb-6 text-center ">Daftar Kelas</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-center mt-3">
            @foreach ($kelas as $item)
                <div
                    class="p-4 shadow-md rounded border-2 border-success-600 outline outline-2 outline-offset-2 outline-success-400">
                    <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                    <p class="text-sm">ID: asd</p>
                    <a href="{{ route('filament.admin.resources.siswas.kelas', ['record' => $item->id]) }}"
                        class="text-blue-300 hover:underline">Lihat
                        Siswa</a>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
