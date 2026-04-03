<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showAuth()
    {
        return view('auth');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        session(['user_id'=>$user->id]);

        return redirect('/tasks');
    }

    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            return back()->with('error','Invalid credentials');
        }

        session(['user_id'=>$user->id]);
        session(['user_name'=>$user->name]);

        return redirect('/tasks');
    }

    public function update_name(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'User not found');
        }

        $user->name = $request->new_name;
        $user->save();

        session(['user_name'=>$user->name]);
        return redirect('/tasks');
    }


    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}
