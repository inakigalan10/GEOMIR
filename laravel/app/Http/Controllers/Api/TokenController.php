<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function user(Request $request)
   {
       $user = User::where('email', $request->user()->email)->first();
      
       return response()->json([
           "success" => true,
           "user"    => $request->user(),
           "roles"   => $user->getRoleNames(),
       ]);
   }
   public function login(Request $request)
   {
       $credentials = $request->validate([
           'email'     => 'required|email',
           'password'  => 'required',
       ]);
       if (Auth::attempt($credentials)) {
           // Get user
           $user = User::where([
               ["email", "=", $credentials["email"]]
           ])->firstOrFail();
           // Revoke all old tokens
           $user->tokens()->delete();
           // Generate new token
           $token = $user->createToken("authToken")->plainTextToken;
           // Token response
           return response()->json([
               "success"   => true,
               "authToken" => $token,
               "tokenType" => "Bearer"
           ], 200);
       } else {
           return response()->json([
               "success" => false,
               "message" => "Invalid login credentials"
           ], 401);
       }
   }

   public function register(Request $request)
   {
       $request->validate([
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'confirmed', Rules\Password::defaults()],

       ]);

       $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
       ]);
       if (Auth::attempt($credentials)) {
        // Get user
        $user = User::where([
            ["email", "=", $credentials["email"]]
        ])->firstOrFail();
        // Revoke all old tokens
        $user->tokens()->delete();
        // Generate new token
        $token = $user->createToken("authToken")->plainTextToken;
        // Token response
        return response()->json([
            "success"   => true,
            "authToken" => $token,
            "tokenType" => "Bearer"
        ], 200);
        } else {
        return response()->json([
            "success" => false,
            "message" => "Invalid login credentials"
        ], 401);

    
   }



}
}