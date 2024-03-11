<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mobils = Mobil::paginate(6);

        return view('admin.mobil.index', compact('mobils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mobil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek' => 'required',
            'model' => 'required',
            'noplat' => 'required|unique:mobils,noplat',
            'harga' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable',
        ], [
            'merek.required' => 'Merek mobil harus diisi!',
            'model.required' => 'Model mobil harus diisi',
            'noplat.required' => 'Nomor plat mobil harus diisi!',
            'noplat.unique' => 'Nomor plat mobil ini sudah ada, silahkan ganti!',
            'deskripsi.required' => 'Deskripsi mobil harus diisi!',
            'harga.required' => 'Harga rental mobil harus diisi!',
        ]);

        if ($validator->fails()) {
            return redirect('/mobil/create')->withErrors($validator)->withInput();
        }
        $mobils = $validator->valid();

        $mobils = new Mobil();
        $mobils->merek = $request->merek;
        $mobils->model = $request->model;
        $mobils->noplat = $request->noplat;
        $mobils->deskripsi = $request->deskripsi;
        $mobils->harga = $request->harga;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('mobil', $fotoName, 'public');
            $mobils->foto = $fotoName;
        }
        // dd($mobils);

        $mobils->save();

        return redirect('/mobil')->with('message', 'Data mobil berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mobils = Mobil::find($id);
        return view('admin.mobil.edit', compact('mobils'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mobils = Mobil::findOrFail($id);

        $validatedData = $request->validate([
            'merek' => 'required',
            'model' => 'required',
            'noplat' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable',
        ], [
            'merek.required' => 'Merek mobil harus diisi!',
            'model.required' => 'Model mobil harus diisi',
            'noplat.required' => 'Nomor plat mobil harus diisi!',
            'deskripsi.required' => 'Deskripsi mobil harus diisi!',
            'harga.required' => 'Harga rental mobil harus diisi!',
        ]);

        $mobils->merek = $validatedData['merek'];
        $mobils->model = $validatedData['model'];
        $mobils->noplat = $validatedData['noplat'];
        $mobils->deskripsi = $validatedData['deskripsi'];
        $mobils->harga = $validatedData['harga'];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('mobil', $fotoName, 'public');
            $mobils->foto = $fotoName;
        }
        // dd($mobils);
        $mobils->save();

        return redirect('/mobil')->with('message', 'Data mobil berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Mobil::destroy($id);
        return redirect('/mobil')->with('message', 'Data mobil berhasil dihapus!');
    }

    // fitur search admin 
    public function searchByName(Request $request)
    {
        $keyword = $request->input('keyword');

        $mobils = Mobil::where(function ($query) use ($keyword) {
            $query->where('merek', 'like', "%$keyword%")
                ->orWhere('model', 'like', "%$keyword%")
                ->orWhere('noplat', 'like', "%$keyword%");
        })->paginate(10);

        return view('admin.mobil.index', compact('mobils', 'keyword'));
    }

    // fitur search user
    public function searchByDate(Request $request)
    {
        $keyword = $request->input('keyword');
        $tanggal = $request->input('tanggal');
        $tanggal = \Carbon\Carbon::parse($tanggal)->format('Y-m-d');

        $mobilTidakTersedia = Peminjaman::where('tgl_mulai', '<=', $tanggal)
            ->where('tgl_akhir', '>=', $tanggal)
            ->pluck('mobil_id')
            ->toArray();
 
        $mobils = Mobil::whereNotIn('id', $mobilTidakTersedia)
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('merek', 'like', '%' . $keyword . '%')
                    ->orWhere('model', 'like', '%' . $keyword . '%');
            })->get();

        return view('user.dashboard.mobil', compact('mobils', 'keyword'));
    }
}
