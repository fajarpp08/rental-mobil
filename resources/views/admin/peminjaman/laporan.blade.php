@extends('admin.layout.main')
@section('content')
    <div class="main_content_iner ">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Laporan Data Peminjaman</h4>
                        </div>
                        <form action="{{ route('cetak_laporanpeminjaman') }}" method="post">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-3">
                                    <div class="white_box mb_30">
                                        <div class="input_wrap common_date_picker mb_20">
                                            <label class="form-label" for="tgl_mulai">Tanggal Mulai</label>
                                            <input class="input_form" id="start_datepicker" name="tgl_mulai"
                                                placeholder="Pilih tanggal mulai" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="white_box mb_30">
                                        <div class="input_wrap common_date_picker mb_20">
                                            <label class="form-label" for="tgl_akhir">Tanggal Akhir</label>
                                            <input class="input_form" id="end_datepicker" name="tgl_akhir"
                                                placeholder="Pilih tanggal akhir" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 d-flex justify-content-center align-items-center mb-6">
                                    <button class="btn_1" type="submit">Export</but>
                                </div>
                            </div>
                        </form>

                        <div class="QA_table mb_30">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor SIM</th>
                                        <th scope="col">Merek Mobil</th>
                                        <th scope="col">Model Mobil</th>
                                        <th scope="col">Nomor Plat</th>
                                        <th scope="col">Lama Rental</th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peminjamans as $peminjaman)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($peminjaman->user)
                                                    {{ $peminjaman->user->nama }}
                                                @else
                                                    nama tidak ditemukan
                                                @endif
                                            </td>
                                            <td>
                                                @if ($peminjaman->user)
                                                    {{ $peminjaman->user->nosim }}
                                                @else
                                                    nomor sim tidak ditemukan
                                                @endif
                                            </td>
                                            <td>
                                                @if ($peminjaman->mobil)
                                                    {{ $peminjaman->mobil->merek }}
                                                @else
                                                    data mobil tidak ditemukan
                                                @endif
                                            </td>
                                            <td>
                                                @if ($peminjaman->mobil)
                                                    {{ $peminjaman->mobil->model }}
                                                @else
                                                    data mobil tidak ditemukan
                                                @endif
                                            </td>
                                            <td>
                                                @if ($peminjaman->mobil)
                                                    {{ $peminjaman->mobil->noplat }}
                                                @else
                                                    nama tidak ditemukan
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_mulai)->isoFormat('DD MMMM YYYY') }}
                                                -
                                                {{ \Carbon\Carbon::parse($peminjaman->tgl_akhir)->isoFormat('DD MMMM YYYY') }}
                                            </td>
                                            <td>{{ $peminjaman->total_harga }}</td>
                                            <td><a
                                                    class="{{ $peminjaman->status_kembali == 1 ? 'status_btn' : 'status_btn red_btn' }}">
                                                    {{ $peminjaman->status_kembali == 1 ? 'Selesai' : 'Proses!' }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- pagination --}}
                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 mt-2 px-4">
                            @if (isset($peminjamans) && $peminjamans instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $peminjamans->links('pagination::bootstrap-5') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
