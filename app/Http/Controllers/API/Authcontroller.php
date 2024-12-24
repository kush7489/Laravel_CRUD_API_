<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Authcontroller extends Controller
{
    //
    public function register(Request $request)
    { {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 201);
        }
    }

    public function login(Request $request)
    {
        // {
        //     $credentials = $request->only('email', 'password');
        //     \Log::info('Login request data: ', $request->all());
        //     if (auth('api')->attempt($credentials)) {
        //         $user = auth('api')->user();
        //         $token = $user->createToken('MyApp')->plainTextToken;

        //         return response()->json(['user' => $user, 'token' => $token], 200);
        //     }

        //     return response()->json(['message' => 'Unauthorized'], 401);

        // }

        {
            try {
                // Log incoming request data for debugging
                Log::info('Login request data: ', $request->all());

                // Validate the request data
                $validator = Validator::make($request->all(), [
                    'email' => 'required|string|email',
                    'password' => 'required|string',
                ]);

                // Check if validation fails
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                // Retrieve user by email
                $user = User::where('email', $request->email)->first();

                // Check if user exists and password is correct
                if ($user && Hash::check($request->password, $user->password)) {
                    // Create token for the authenticated user
                    $token = $user->createToken('MyApp')->plainTextToken;

                    // Return response with user and token
                    return response()->json(['user' => $user, 'token is' => $token], 200);
                }

                // If authentication fails
                return response()->json(['message' => 'Unauthorized'], 401);
            } catch (\Exception $e) {                 
                Log::error('Login error: ' . $e->getMessage());
                return response()->json(['message' => 'Server error'], 500);
            }
        }
    }

     
}
