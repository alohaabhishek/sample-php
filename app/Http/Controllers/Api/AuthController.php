<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(['error'=>'Email already exists'], 422);
        }
        
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $token = JWTAuth::claims([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ])->fromUser($user);

        return response()
            ->json(['message'=>'User created'])
            ->header('Authorization', 'Bearer '.$token);
    }

    // LOGIN (manual validation)
    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error'=>'Invalid credentials'], 400);
        }

        $token = JWTAuth::claims([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ])->fromUser($user);

        return response()
            ->json(['message'=>'Login successful'])
            ->header('Authorization', 'Bearer '.$token);
    }

    // REFRESH TOKEN
    public function refresh(Request $request)
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();

            return response()
                ->json(['message'=>'Token refreshed'])
                ->header('Authorization', 'Bearer '.$newToken);

        } catch (\Exception $e) {
            return response()->json(['error'=>'Invalid token'], 401);
        }
    }

    // LOGOUT
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message'=>'Logged out']);
    }
}