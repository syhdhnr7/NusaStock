<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function checkUsername(Request $request)
    {
        $user = User::where('name', $request->name)->first();

        if (!$user) {
            return back()->with('error', 'Nama tidak ditemukan');
        }

        return view('auth.passwords.reset', compact('user'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $user = User::find($request->user_id);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/login')
            ->with('success', 'Password berhasil diubah');
    }
}
