<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mobil;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ADMIN
    public function dashboardAdmin()
    {
        $mobilData = Mobil::take(6)->get();
        return view(
            'admin.dashboard.index',
            [
                'mobils' => Mobil::all(),
                'peminjamans' => Peminjaman::all(),
                'pengembalians' => Pengembalian::all(),
                'users' => User::all(),
                'mobilData' => $mobilData
            ]
        );
    }

    // USER
    public function dashboardUser()
    {
        $mobils = Mobil::all();
        return view('user.dashboard.index', compact('mobils'));
    }
    public function mobilUser()
    {
        $mobils = Mobil::all();
        $mobils = Mobil::paginate(6);
        return view('user.dashboard.mobil', compact('mobils'));
    }
    public function mobilDetail($id)
    {
        $mobils = Mobil::find($id);
        $mobilsAll = Mobil::all();
        return view('user.dashboard.detail', compact('mobils', 'mobilsAll'));
    }
    public function account()
    {
        // $users = Auth::user();
        // $mobilsAll = Mobil::all();
        return view(
            'user.dashboard.account'
            // , [
            //     'users' => $users,
            // ]
        );
    }
}
