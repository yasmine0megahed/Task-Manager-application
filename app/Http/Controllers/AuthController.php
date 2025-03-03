<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
       // Login method 
       public function login(Request $request)
       {
           // Validate 
           $request->validate([
               'email' => 'required|email',
               'password' => 'required|min:6', 
           ]);
   
           // Check  the email and the password are correct
           if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                /** @var \App\Models\User $user */
               $user = Auth::user();
               $token = $user->createToken('API Token')->plainTextToken;
   
               // Return a response with the token
               return response()->json([
                   'message' => 'Login successful',
                   'token' => $token,
               ], 200);
           }
   
           // If authentication fails, return an error
           return response()->json([
               'message' => 'Unauthorized',
           ], 401);
       }
}
