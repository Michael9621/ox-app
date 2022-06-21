<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\User;
use Illuminate\Support\Facades\Auth;
 

class PhotoController extends Controller
{
    public function create(Request $request){
        //https://www.nicesnippets.com/blog/laravel-7-ajax-form-validation

        /*$request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);*/

        $user = User::find($request->user_id);
        
        //dd(User::find($request->user_id));
  
        $featured = $request->photo;

            $featured_new_name = time().$featured->getClientOriginalName();

            $featured->move('uploads/content', $featured_new_name);
        //dd(request()->file('photo'));


        

        
        $photo = Photo::create([
            "img" => $featured_new_name,
            "user_id" => Auth::user()->id
        ]);


        $photo->musers()->attach($user);
    

        return response()->json($photo);
    }


    public function edit(Request $request, Photo $photo){
        
        return response()->json($photo);

    }

    public function update(Request $request, Photo $photo){
        $photo->img = $request->img;
        $photo->user_id= $request->user_id;
        $photo->save();
    }

    public function trashed_photos(Photo $photo){
        $photo->delete();
    }

    public function destroy(Photo $photo){
        //delete all the photos
        // Force deleting a single model instance...
        $photo->forceDelete();
        
        // Force deleting all related models...
        $photo->history()->forceDelete();
    }
}