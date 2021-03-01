<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\User;
use Auth;
use Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }
    public function update(Request $request, $id)
    {
        dd('fsdfsd');
    }
    public function updateThumb(Request $request, $id, \App\Services\ImageService $imageservice)
    {
        $user = User::find($id);
        
        $request->validate([            
            'profile_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $imageName = $user->profile_photo;
       
        if($request->file('profile_photo')) {
            
            // If profile photo exist before then delete it
            if($imageName) {
                $imageservice->deleteImage($imageName, 'users');
            }
            // Upload profile photo
            $imageName = $imageservice->init(
                $request->file('profile_photo'), 'users', $request->lg_w, $request->lg_h, false
            )->crop($request->lg_x1, $request->lg_y1)->upload();
        }

        $status = $user->update([            
            'profile_photo' => $imageName
        ]);
        dd($status);
        if($status) {
            return redirect()->route('profile')->with('success','User Profile Updated Successfully!');
        } else {
            return redirect()->route('profile')->with('error','User Profile cannot be Updated!');
        }
    }

    public function changePassword()
    {
        return view('settings.change-password');
    }

    public function updatePassword(Request $request)
    {
        if(Auth::check()) {
            $request->validate([
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => ['required'],
                'confirm_new_password' => ['same:new_password']
            ]);
            User::find(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->route('changePwd')->with('success', 'Password changed successfully.');
        }
        return redirect()->route('/');    
    }
}
