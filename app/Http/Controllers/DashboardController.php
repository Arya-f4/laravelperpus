<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function userDashboard()
    {
        $user = auth()->user();
        $activeBorrowings = Peminjaman::where('id', $user->id)
            ->where('status', 'dipinjam')
            ->with('buku')
            ->get();
        $pendingRequests = Peminjaman::where('id', $user->id)
            ->where('status', 'menunggu konfirmasi')
            ->with('buku')
            ->get();

        return view('dashboard.user', compact('activeBorrowings', 'pendingRequests'));
    }

    public function adminDashboard()
    {
        $totalBooks = Buku::count();
        $totalUsers = User::count();
        $activeBorrowings = Peminjaman::where('status', 'dipinjam')->count();
        $pendingRequests = Peminjaman::where('status', 'menunggu konfirmasi')->count();

        return view('dashboard.admin', compact('totalBooks', 'totalUsers', 'activeBorrowings', 'pendingRequests'));
    }
}
