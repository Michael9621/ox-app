<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Photo;
use App\Status;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function home(){
        $user = Auth::user();
        //dd($user->mphotos()->latest()->get());
   
        //dd([$user->status()->latest()->first()->created_at);
        $user_last_logout='';
        //dd($user->photos()->count() );
        if($user->status()->count() > 0){
            $user_last_logout= $user->status()->latest()->first()->created_at;
        }
        
        return view('welcome')
        ->with('user',$user)
        ->with('user_last_logout', $user_last_logout);
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

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique',
            'password' => 'required|confirmed|min:6',
        ]);

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

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique',
            'password' => 'required|confirmed|min:6',
        ]);

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
            $data =User::role('Receiver')->select("id","name")
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
            if (Auth::user()->hasRole('Receiver')){
                Status::create([
                    "user_id" => Auth::user()->id,
                    "type"=> 0
                ]);
            }
            return redirect()->route('home');
        } else {
            $loginError="your login credentials are incorrect";
            return redirect('login')->with('loginError', 'login credentials are incorrect');;
        }
    }


    public function logout(){
        //dd(Auth::user()->name);

        if (Auth::user()->hasRole('Receiver')){
            Status::create([
                "user_id" => Auth::user()->id,
                "type" => 1
            ]);
        }

        Auth::logout();
       
        return redirect()->route('login');
    }



    
}
