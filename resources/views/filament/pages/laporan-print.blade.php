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
        <p><strong>Periode Bulan:</strong> {{ $bulan }} </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                {{-- <th>Nama</th> --}}
                <th>Tanggal Transaksi</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Jumlah</th>
                {{-- <th>Dibuat Pada</th>
                <th>Diperbarui Pada</th>
                <th>Dihapus Pada</th> --}}
            </tr>
        </thead>
        <tbody>

            @php
                $total_debet = 0;
                $total_kredit = 0;
                $total_jumlah = $saldo_awal;
            @endphp
            <tr class="total-row">
                <td colspan="4" style="text-align: left;">Saldo Awal</td>
                <td style="text-align: right;">{{ number_format($total_jumlah, 0, ',', '.') }}</td>
                <td></td>
                <td style="text-align: right;">{{ number_format($total_jumlah, 0, ',', '.') }}</td>
            </tr>
            @foreach ($records as $record)
                @php
                    if ($record->kategori_transaksi->jenis_transaksi) {
                        $total_jumlah += $record->jumlah;
                        $total_debet += $record->jumlah;
                    } else {
                        $total_jumlah -= $record->jumlah;
                        $total_kredit += $record->jumlah;
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->tgl_transaksi)->format('d-m-Y') }}</td>
                    {{-- <td>{{ $record->name }}</td> --}}
                    <td>{{ $record->kategori_transaksi->name }}</td>
                    <td>{{ $record->keterangan }}</td>
                    @if ($record->kategori_transaksi->jenis_transaksi)
                        <td style="text-align: right;">{{ number_format($record->jumlah, 0, ',', '.') }}</td>
                        <td style="text-align: right;"></td>
                        <td style="text-align: right;">{{ number_format($total_jumlah, 0, ',', '.') }}</td>

                        {{-- <span style="color: green;">↑</span> Pemasukkan --}}
                    @else
                        <td style="text-align: right;"></td>
                        <td style="text-align: right;">{{ number_format($record->jumlah, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($total_jumlah, 0, ',', '.') }}</td>
                        {{-- <span style="color: red;">↓</span> Pengeluaran --}}
                    @endif



                    {{-- <td style="text-align: right;">{{ \Carbon\Carbon::parse($record->created_at)->format('d-m-Y H:i:s') }}</td> --}}
                    {{-- <td style="text-align: right;">{{ \Carbon\Carbon::parse($record->updated_at)->format('d-m-Y H:i:s') }}</td>
                <td style="text-align: right;">{{ $record->deleted_at ? \Carbon\Carbon::parse($record->deleted_at)->format('d-m-Y H:i:s') : 'N/A' }}</td> --}}
                </tr>
            @endforeach
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: center;">Total</td>
                <td style="text-align: right;">{{ number_format($total_debet, 0, ',', '.') }}</td>
                <td style="text-align: right;">{{ number_format($total_kredit, 0, ',', '.') }}</td>
                <td style="text-align: right;">{{ number_format($total_jumlah, 0, ',', '.') }}</td>
                {{-- <td colspan="1"></td> --}}
            </tr>
        </tfoot>
        </tbody>
    </table>

    <div class="footer">
        <!-- Tanda Tangan Kiri -->
        <div class="signature">
            {{-- @dd($ketua_umum) --}}
            {{ $ketua_umum->name ?? '' }}
            <br>
            ( {{ $ketua_umum->jabatan->name ?? 'KETUA UMUM' }} )
            <br>
            <br>
            <br>
            <br>
            <p></p>
        </div>
        <div class="signature">
            {{ $kepala_sekolah->name ?? '' }}
            <br>( {{ $kepala_sekolah->jabatan->name ?? 'KEPALA SEKOLAH' }} )
            <br>
            <br>
            <br>
            <br>
            <p>
            </p>
        </div>

        <!-- Tanda Tangan Kanan -->
        <div class="signature">
            {{ $bendahara->name ?? '' }}
            <br>( {{ $bendahara->jabatan->name ?? 'BENDAHARA SEKOLAH' }} )
            <br>
            <br>
            <br>
            <br>
            <p>
            </p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
