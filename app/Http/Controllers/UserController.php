<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user/index', [
            "users" => $users
        ]);
    }

    public function store(Request $request)
    {
        //validasi data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required',
        ]);

        return redirect('/user');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect('/user')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/user')->with('success', 'Data berhasil dihapus');
    }
}
