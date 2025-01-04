<x-filament-panels::page>
    <div>
        <h1 class="text-2xl font-bold mb-6">Daftar Kelas</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($kelas as $item)
                <div class="p-4 bg-white shadow-md rounded">
                    <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                    <p class="text-sm text-gray-600">ID: {{ $item->id }}</p>
                    <a href="" class="text-blue-500 hover:underline">Lihat Jabatan</a>
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
