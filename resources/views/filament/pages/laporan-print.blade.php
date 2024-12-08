<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .signature {
            text-align: center;
            width: 30%;
        }

        .signature p {
            margin-top: 60px;
            border-top: 1px solid black;
            display: inline-block;
            width: 80%;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Data Keuangan</h1>
        <p><strong>Periode:</strong> {{ $start_date }} - {{ $end_date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Nama Kategori</th>
                <th>Tipe</th>
                <th>Tanggal Transaksi</th>
                <th>Jumlah</th>
                <th>Gambar</th>
                {{-- <th>Dibuat Pada</th>
                <th>Diperbarui Pada</th>
                <th>Dihapus Pada</th> --}}
            </tr>
        </thead>
        <tbody>
            <@php
                $total_jumlah = 0;
            @endphp @foreach ($records as $record)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->kategori_transaksi->name }}</td>
                    <td>
                        @if ($record->kategori_transaksi->jenis_transaksi)
                            <span style="color: green;">↑</span> Pemasukkan
                        @else
                            <span style="color: red;">↓</span> Pengeluaran
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($record->tgl_transaksi)->format('d-m-Y') }}</td>
                    <td>{{ number_format($record->jumlah, 0, ',', '.') }}</td>
                    <td>
                        @if ($record->gambar)
                            <img src="{{ asset('storage/' . $record->gambar) }}" alt="Image" width="100">
                        @else
                            No Image
                        @endif
                    </td>
                    {{-- <td>{{ \Carbon\Carbon::parse($record->created_at)->format('d-m-Y H:i:s') }}</td> --}}
                    {{-- <td>{{ \Carbon\Carbon::parse($record->updated_at)->format('d-m-Y H:i:s') }}</td>
                <td>{{ $record->deleted_at ? \Carbon\Carbon::parse($record->deleted_at)->format('d-m-Y H:i:s') : 'N/A' }}</td> --}}
                </tr>
                @php
                    if ($record->kategori_transaksi->jenis_transaksi) {
                        $total_jumlah += $record->jumlah;
                    } else {
                        $total_jumlah -= $record->jumlah;
                    }
                @endphp
                @endforeach
        <tfoot>
            <tr class="total-row">
                <td colspan="5" style="text-align: right;">Total Jumlah</td>
                <td>{{ number_format($total_jumlah, 0, ',', '.') }}</td>
                <td colspan="1"></td>
            </tr>
        </tfoot>
        </tbody>
    </table>

    <div class="footer">
        <!-- Tanda Tangan Kiri -->
        <div class="signature">
            <p>Tanda Tangan Kiri</p>
        </div>

        <!-- Tanda Tangan Kanan -->
        <div class="signature">
            <p>Tanda Tangan Kanan</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
