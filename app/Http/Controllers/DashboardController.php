<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\Penerbit;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        $user = auth()->user();
        $activeBorrowings = Peminjaman::where('peminjam_id', $user->id)
            ->where('status', 'dipinjam')
            ->with('buku')
            ->get();
        $pendingRequests = Peminjaman::where('peminjam_id', $user->id)
            ->where('status', 'menunggu konfirmasi')
            ->with('buku')
            ->get();
        $pendingDendas = Denda::whereHas('peminjaman', function ($query) use ($user) {
            $query->where('peminjam_id', $user->id);
        })
            ->where('is_paid', false)
            ->get();

        return view('dashboard.user', compact('activeBorrowings', 'pendingRequests', 'pendingDendas'));
    }

    public function adminDashboard()
    {

        $totalBooks = Buku::count();
        $totalUsers = User::count();
        $activeBorrowings = Peminjaman::where('status', 'dipinjam')->count();
        $totalBorrowings = Peminjaman::count();
        $totalFines = Denda::sum('total_denda');
        $aktivitas_user = UserActivityLog::paginate(5);
        $penerbit = Penerbit::all();
        $bukuData = Buku::selectRaw('penerbit_id, count(*) as jumlah')
                ->groupBy('penerbit_id')
                ->get();
        
        // buku per penerbit
        $labels = $bukuData->map(function ($item) {
            return Penerbit::find($item->penerbit_id)->nama;
        });
        
        $data = $bukuData->map(function ($item) {
            return $item->jumlah;
        });

        $recentBorrowings = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        $popularBooks = Buku::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();
        $pendingRequests = Peminjaman::where('status', 'menunggu konfirmasi')->count();
        // return $active_users;
        return view('dashboard.admin', compact('aktivitas_user', 'labels', 'data','totalBooks', 'totalUsers', 'activeBorrowings', 'totalBorrowings', 'totalFines', 'pendingRequests', 'recentBorrowings', 'popularBooks'));
    }

    private function petugasDashboard()
    {
        $pendingReturns = Peminjaman::where('status', 'borrowed')
            ->where('tanggal_pengembalian', '<', now())
            ->with(['user', 'buku'])
            ->get();

        $recentBorrowings = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.petugas', compact('pendingReturns', 'recentBorrowings'));
    }
    public function index()
    {

        if (auth()->user()->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif (auth()->user()->hasRole('petugas')) {
            return $this->petugasDashboard();
        } else {
            return $this->userDashboard();
        }
    }
}
