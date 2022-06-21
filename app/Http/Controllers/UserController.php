<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Photo;
use App\Status;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    public function home(){
        $user = Auth::user();
        //$photos = Photo::latest()->get();
        return view('welcome')
        ->with('user',$user);
       // ->with('photos', $photos);
    }

    
    /**
     * returns the signup view for a receiver user
     */
    public function signup(){
        return view('signup');
    }

    public function signupSender(){
        return view('signupSender');
    }
    
    /**
     * registers the user (sender)
     * redirects to login page
     */
    public function receiverRegister(Request $request){

        $role = Role::where('name', 'Receiver')->get();

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);

        return redirect()->route('login');
    }


    public function senderRegister(Request $request){

        $role = Role::where('name', 'Sender')->get();

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);

        return redirect()->route('login');
    }


    //find a user
    public function autocomplete(Request $request){

        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data =User::select("id","name")
                    ->where("name", "!=", Auth::user()->name)
            		->where('name','LIKE',"%$search%")
            		->get();
        }
        
        return response()->json($data);

    }

    /**
     * @returns login view
     */
    public function login(){
        return view('login');
    }


    /***
     * login user & re-direct to home page
     */

    public function auth(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home');
        } else {
            dd('your username and password are wrong.');
        }
    }


    public function logout(){
        //dd(Auth::user()->name);
        Status::create([
            "user_id" => Auth::user()->id
        ]);
        Auth::logout();
        return redirect()->route('login');
    }



    
}
