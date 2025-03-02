<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;    
use Illuminate\Http\Request;

class userController extends Controller
{
function login(Request $request){
  $request->validate([
    'email'=>'required|email',
    'password'=>'required'
  ]);
  if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
    $user = Auth::user();
    $token=$user->createToken('zyler')->plainTextToken;
    return response()->json(['token'=>$token,'user'=>$user]);
  }
}
function user(){
$user=User::where('id','!=',Auth::id())->orderby('id','desc')->get();
return response()->json($user);
}

function adduser(Request $request){
    $request->validate([
        'name'=>'required',
        'email'=>'required|email',
        'password'=>'required'
      ]);
      User::create([
        'name'=>$request['name'],
        'email'=>$request['email'],
        'password'=>bcrypt($request['password'])
      ]);
      $user=User::where('id','!=',Auth::id())->orderby('id','desc')->get();
      return response()->json(['message'=>'User Added Successfully','status'=>200,'user'=>$user]);
}

function delete($id)  {
    User::destroy($id);
    $user=User::where('id','!=',Auth::id())->orderby('id','desc')->get();
    return response()->json(['message'=>'User Deleted Successfully','status'=>200,'user'=>$user]);
}

}

