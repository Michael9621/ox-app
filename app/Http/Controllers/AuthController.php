<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    
    public function signup(){
        return view('signup');
    }
    
    //register users
    public function userRegister(Request $request){

        $role = Role::where('name', 'Sender')->get();

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);
    }

    //register users
    public function receiver(Request $request){

        $role = Role::where('name', 'Receiver')->get();

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);
    }


    //login -- authenticate
    public function userAuth(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
          return redirect()->route('user.dashboard');
        } else {
            dd('your username and password are wrong.');
        }
    }


    //logout
    public function userLogout(){
        Auth::logout();
        //return redirect()->route('user-loginForm');
    }

}
