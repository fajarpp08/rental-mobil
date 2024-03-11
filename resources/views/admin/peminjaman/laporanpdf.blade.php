<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman</title>
    <style type="text/css">
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            font-size: 10pt;
            /* Ukuran font diperkecil */
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h5 class="card-header" style="text-align: center;">Laporan Peminjaman</h5>

        <table>
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nomor SIM</th>
                    <th>Merek Mobil</th>
                    <th>Model Mobil</th>
                    <th>Nomor Plat</th>
                    <th>Lama Rental</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @php $i=1 @endphp
                @foreach ($peminjamans as $peminjaman)
                    <tr class="text-center">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="table-cell">
                            @if ($peminjaman->user)
                                {{ $peminjaman->user->nama }}
                            @else
                                nama tidak ditemukan
                            @endif
                        </td>
                        <td class="table-cell">
                            @if ($peminjaman->user)
                                {{ $peminjaman->user->nosim }}
                            @else
                                nosim tidak ditemukan
                            @endif
                        </td>
                        <td class="table-cell">
                            @if ($peminjaman->mobil)
                                {{ $peminjaman->mobil->merek }}
                            @else
                                merk tidak ditemukan
                            @endif
                        </td>
                        <td class="table-cell">
                            @if ($peminjaman->mobil)
                                {{ $peminjaman->mobil->model }}
                            @else
                                merk tidak ditemukan
                            @endif
                        </td>
                        <td class="table-cell">
                            @if ($peminjaman->mobil)
                                {{ $peminjaman->mobil->noplat }}
                            @else
                                noplat tidak ditemukan
                            @endif
                        </td>
                        <td class="table-cell">{{ \Carbon\Carbon::parse($peminjaman->tgl_mulai)->isoFormat('DD MMMM') }}
                            -
                            {{ \Carbon\Carbon::parse($peminjaman->tgl_akhir)->isoFormat('DD MMMM YYYY') }}</td>
                        <td class="table-cell">{{ $peminjaman->total_harga }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
