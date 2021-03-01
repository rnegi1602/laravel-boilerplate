<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;

class ProfileController extends Controller
{
    public function changePassword()
    {
        return view('settings.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'confirm_new_password' => ['same:new_password']
        ]);
        dd('Password change successfully.');
       
    }
}
