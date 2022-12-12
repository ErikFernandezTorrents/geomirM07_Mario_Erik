<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
       $user = User::where('email', $request->user()->email)->first();
      
       return response()->json([
           "success" => true,
           "user"    => $request->user(),
           "roles"   => $user->getRoleNames(),
       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        
            $user= User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $user->assignRole('author');

            $token = $user->createToken("authToken")->plainTextToken;

            return response()->json([
                'success' => true,
                'authToken' => $token,
                'tokenType' => "Bearer"
            ], 200);
        

        //return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
