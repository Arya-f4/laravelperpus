<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->role_id
        ];

        User::insert($data);
        return redirect('/users/all');
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($id);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->filled('newsecurepassword')) {
            $user->password = bcrypt($validated['newsecurepassword']);
        }
        $user->role_id = $validated['role_id'];
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->back();
    }
}
