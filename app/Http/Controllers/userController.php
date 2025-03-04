<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;    
use Illuminate\Http\Request;

class userController extends Controller
{
  public function login(Request $request)
  {
      $request->validate([
          'email' => 'required|email',
          'password' => 'required'
      ]);
  
      if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
          return response()->json(['error' => 'Invalid email or password','status'=>401]);
      }
  
      $user = Auth::user();
      $token = $user->createToken('zyler')->plainTextToken;
  
      return response()->json(['token' => $token, 'user' => $user]);
  }
function user(){
$user=User::where('id','!=',Auth::id())->orderby('id','desc')->get();
return response()->json(['user'=>$user,'id'=>Auth::id()]);
}

function adduser(Request $request){
    $request->validate([
        'name'=>'required|unique:users,name',
        'email'=>'required|email|unique:users,email',
        'password'=>'required'
      ]);
      User::create([
        'name'=>$request['name'],
        'email'=>$request['email'],
        'password'=>bcrypt($request['password'])
      ]);
      $user=User::where('id','!=',Auth::id())->orderby('id','desc')->get();
  return response()->json(['message'=>'User Added Successfully','status'=>200,'user'=>$user,'ol'=>Auth::user()->id]);
}

function update(Request $request,$id){
    $request->validate([
        'name'=>'required|unique:users,name,'.$id,
        'email'=>'required|email|unique:users,email,'.$id,
        
      ]);
      $user=User::find($id);
      $user->name=$request['name'];
      $user->email=$request['email'];

      $user->save();
      $user=User::where('id','!=',Auth::id())->orderby('id','desc')->get();
      return response()->json(['message'=>'User Updated Successfully','status'=>200,'user'=>$user]);
}

function delete($id)  {
 User::destroy($id);
    $user=User::where('id','!=',Auth::id())->orderby('id','desc')->get();
    return response()->json(['message'=>'User Deleted Successfully','status'=>200,'user'=>$user]);
}
function logout(Request $request) {
  
  $request->user()->tokens()->delete();
return response()->json(['message'=>'Logged Out Successfully','status'=>200]);
}
}

