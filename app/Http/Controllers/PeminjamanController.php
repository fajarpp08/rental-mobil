<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mobil;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // ADMIN
    public function index()
    {
        $peminjamans = Peminjaman::paginate(10); // 10 items per page

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjamans, $id)
    {
        return view('admin.peminjaman.edit', [
            'peminjamans' => Peminjaman::find($id),
            'users' => User::all(),
            'mobils' => Mobil::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $peminjamans = Peminjaman::findOrFail($id);

        $validatedData = $request->validate([
            'tgl_mulai' => 'required',
            'tgl_akhir' => 'required',
            'total_harga' => 'required',
            'mobil_id' => 'required',
            'user_id' => 'required',
            // 'status_kembali' => 'nullable',
        ], [

            'tgl_mulai.required' => 'kolom tanggal harus diisi',
            'tgl_akhir.required' => 'kolom tanggal harus diisi',
            'total_harga.required' => 'kolom total harus diisi',
            'mobil_id.required' => 'kolom mobil plat harus diisi',
            'user_id.required' => 'kolom user harus diisi',
            // 'status_kembali.nullable' => 'status kembali',
        ]);


        $peminjamans->tgl_mulai = $validatedData['tgl_mulai'];
        $peminjamans->tgl_akhir = $validatedData['tgl_akhir'];
        $peminjamans->total_harga = $validatedData['total_harga'];
        $peminjamans->mobil_id = $validatedData['mobil_id'];
        $peminjamans->user_id = $validatedData['user_id'];
        // $peminjamans->status_kembali = $validatedData['status_kembali'];

        $peminjamans->save();

        return redirect('/peminjaman')->with('message', 'Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Peminjaman::destroy($id);
        return redirect('/peminjaman')->with('message', 'Data berhasil dihapus');
    }


    public function laporan()
    {
        $peminjamans = Peminjaman::paginate(10);

        return view('admin.peminjaman.laporan', compact('peminjamans'));
    }
    public function cetakLaporan(Request $request)
    {
        $tanggalMulai = Carbon::parse($request->input('tgl_mulai'));
        $tanggalAkhir = Carbon::parse($request->input('tgl_akhir'))->endOfDay();

        $peminjamans = Peminjaman::whereBetween('created_at', [$tanggalMulai, $tanggalAkhir])->get();
        $pdf = PDF::loadview('admin.peminjaman.laporanpdf', ['peminjamans' => $peminjamans]);
        return $pdf->download('Laporan_Peminjaman.pdf');
    }



    // USER 
    public function formPeminjaman($mobil_id)
    {
        $users = Auth::user();
        $mobils = Mobil::findOrFail($mobil_id);

        // Mengambil data tanggal yang sudah dipesan
        $tglRental = Peminjaman::where('mobil_id', $mobil_id)
            ->where(function ($query) {
                $query->where('tgl_akhir', '>=', now())
                    ->orWhere('tgl_mulai', '>=', now());
            })
            ->pluck('tgl_mulai', 'tgl_akhir')
            ->flatten();

        return view('user.transaksi.forms', [
            'mobils' => $mobils,
            'users' => $users->nama,
            'nama' => $users->nosim,
            'tglRental' => $tglRental,
        ]);
    }

    public function createPeminjaman(Request $request)
    {
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date|after:tgl_mulai',
            'mobil_id' => 'required|exists:mobils,id',
        ]);

        // Mengambil data user login
        $user_id = Auth::id();

        // Mengambil data mobil 
        $mobils = Mobil::findOrFail($request->input('mobil_id'));

        // Hitung total harga berdasarkan dari tanggal mulai - tanggal selesai
        $tgl_mulai = Carbon::parse($request->input('tgl_mulai'));
        $tgl_akhir = Carbon::parse($request->input('tgl_akhir'));
        $totalHarga = $mobils->harga * $tgl_mulai->diffInDays($tgl_akhir);

        // Isi data
        $peminjamans = new Peminjaman();
        $peminjamans->user_id = $user_id;
        $peminjamans->tgl_mulai = $request->tgl_mulai;
        $peminjamans->tgl_akhir = $request->tgl_akhir;
        $peminjamans->total_harga = $totalHarga;
        $peminjamans->mobil_id = $request->mobil_id;

        // Save data 
        $peminjamans->save();

        return redirect()->route('rentalan')->with('success', 'Rental berhasil dilakukan.');
    }

    public function rentalan()
    {
        $user = Auth::user();
        // Mengambil data peminjaman dari data user yang login
        $rentalanUser = $user->peminjamans ?? collect();
        // dd($rentalanUser);

        // Mengambil data peminjaman 
        $rentalanPagination = Peminjaman::paginate(6);

        $rentalanUser->each(function ($rentalans) {
            $rentalans->status_kembali = $rentalans->pengembalian()->exists();
        });

        return view('user.dashboard.peminjaman', compact('rentalanUser', 'rentalanPagination'));
    }

    public function kembalikan($peminjamanId)
    {
        // Membuat data $peminjamanId adalah tipe data integer
        $peminjamanId = (int)$peminjamanId;

        // Cek data id peminjaman
        $peminjaman = Peminjaman::find($peminjamanId);

        // validasi jika tidak ada data peminjaman
        if (!$peminjaman) {
            return redirect()->route('rentalan')->with('error', 'Data peminjaman tidak ditemukan!');
        }

        // Menambahkan data ke tabel pengembalian
        $pengembalian = new Pengembalian([
            // Input data tgl_kembali otomatis sesuai tanggal pada saat dikembalikan 
            'tgl_kembali' => now(),
        ]);

        $peminjaman->pengembalian()->save($pengembalian);
        // dd($peminjaman);
        // Membuat data status_kembali menjadi true = 1
        $peminjaman->status_kembali = true;

        $peminjaman->save();

        return redirect()->route('rentalan')->with('success', 'Mobil telah dikembalikan.');
    }
}
