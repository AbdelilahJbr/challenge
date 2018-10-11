<?php

namespace App\Http\Controllers;

use App\User;
use App\Shop;
use App\Liked;
use App\Disliked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function deleteLiked($id)
    {
        Liked::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function deleteDisliked($id)
    {
        Disliked::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    public function addLiked($id, $shop_id, Request $request)
    {
        $liked = Liked::create();
        $liked->user_id = $id;
        $liked->shop_id = $shop_id;
        $liked->save();
        $user = User::findOrfail($id);
        return response()->json($user->liked, 200);
    }

    public function addDisliked($id, $shop_id, Request $request)
    {
        $disliked = Disliked::create();
        $disliked->user_id = $id;
        $disliked->shop_id = $shop_id;
        $disliked->save();
        $user = User::findOrfail($id);
        return response()->json($user->disliked, 200);
    }

    public function showAllUsers()
    {
        return response()->json(User::all());
    }

    public function showOneUser($id)
    {
        return response()->json(User::find($id));
    }

    public function showUserDislikedShops($id)
    {
        return response()->json(User::find($id)->disliked);
    }

    public function showUserLikedShops($id)
    {
        return response()->json(User::find($id)->liked);
    }

    public function create(Request $request)
    {
        $user = User::create($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json($user, 201);
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    /**
    * Check user credentials
    *
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
      $this->validate($request, [
      'email'    => 'required',
      'password' => 'required'
     ]);

      $user = User::where('email', $request->input('email'))->first();

      if(Hash::check($request->password, $user->password)){
       $apikey = base64_encode(str_random(32));
       User::where('email', $request->input('email'))->update(['api_key' => $apikey]);

       return response()->json(['status' => 'success','api_key' => $apikey]);
      }
      else{

          return response()->json(['status' => 'fail'],401);
      }
    }
}