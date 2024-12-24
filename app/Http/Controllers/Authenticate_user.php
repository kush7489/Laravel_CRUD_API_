<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class Authenticate_user extends Controller
{
    public function dashboard(Request $request)
    {
        // Log::info('Request data is : ', $request->all());    
        // try {
        //     return response()->json(['message' => "verified user "]);
        // } catch (AuthenticationException $e) {
        //     return response()->json(['message' => 'Unauthorized: Invalid or expired token'], 401);
        // }

        try {
            
            $user = auth('api')->user();

            if (!$user) {
               
                throw new AuthenticationException('Unauthenticated.');
            }

             
            return response()->json(['user' => $user]);
        } catch (AuthenticationException $e) {
             
            return response()->json(['message' => 'Unauthorized: Invalid or expired token'], 401);
        }
    }
}
