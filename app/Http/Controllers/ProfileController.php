<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // public function changepass()
    // {

    //     return view('profile.change_pass');
    // }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('front.news');
    }
    public function passwordUpdate(Request $request)
    {
        $validateData = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',

        ]);
        $HashedPassword = Auth::user()->password;

        if (Hash::check($request->old_password, $HashedPassword)) {
            $user = User::find(Auth::id());

            $user->password = Hash::make($request->password);
            $user->save();

            // Auth::logout();
            return redirect()->route('front.news')->with('success', 'Password Changed Succesfully');
        } else {
            return redirect()->back()->with('error', 'Current Password is Incorrect');
        }
    }
}
