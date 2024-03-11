@extends('admin.layout.main')
@section('content')
    <div class="main_content_iner ">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="QA_section">
                        <div class="white_box_tittle list_header">
                            <h4>Data Peminjaman</h4>
                            <div class="box_right d-flex lms_block">
                                <div class="serach_field_2">
                                    <div class="search_inner">
                                        <form Active="#">
                                            <div class="search_field">
                                                <input type="text" placeholder="Search content here...">
                                            </div>
                                            <button type="submit"> <i class="ti-search"></i> </button>
                                        </form>
                                    </div>
                                </div>
                                {{-- <div class="add_button ms-2">
                                    <a href="/useradm/create" class="btn_1">Add New</a>
                                </div> --}}
                            </div>
                        </div>
                        <div class="QA_table mb_30">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor SIM</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Mobil</th>
                                        <th scope="col">Nomor Plat</th>
                                        <th scope="col">Lama Rental</th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
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
                                                @if ($peminjaman->mobil->foto)
                                                    <img src="{{ asset('storage/mobil/' . $peminjaman->mobil->foto) }}"
                                                        alt="mobil" class="img-fluid" width="150">
                                                @else
                                                    <img src="{{ asset('images/foto-profile.png') }}" alt="mobil"
                                                        class="img-fluid rounded-circle" width="80">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($peminjaman->mobil)
                                                    {{ $peminjaman->mobil->merek }} - {{ $peminjaman->mobil->model }}
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
                                            {{-- <td>{{ $peminjaman->status_kembali }}</td> --}}
                                            <td><a
                                                    class="{{ $peminjaman->status_kembali == 1 ? 'status_btn' : 'status_btn red_btn' }}">
                                                    {{ $peminjaman->status_kembali == 1 ? 'Selesai' : 'Proses!' }}</a>
                                            </td>
                                            <td>
                                                <ul class="list-inline m-0">
                                                    <a href="/peminjaman/{{ $peminjaman->id }}/edit"
                                                        class="list-inline-item">
                                                        <button class="btn btn-success btn-sm rounded-0" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                                class="fa fa-edit"></i></button>
                                                    </a>
                                                    <form action="/peminjaman/{{ $peminjaman->id }}" method="post"
                                                        class="list-inline-item">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm rounded-0" type="submit"
                                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                                onclick="return confirm('Yakin akan menghapus data?')"
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </ul>
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
