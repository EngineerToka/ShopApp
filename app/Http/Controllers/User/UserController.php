<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users= User::all();
        return response()->json(
            [
            'users'=>$users
            ]
          );
    }


    public function store(UserRequest  $request)
    {
        $userData = $request->validated();

        if($request->hasFile('profile_image')){
            $path = $request->file('profile_image')->store('profile_images','public');
            $userData['profile_image']=$path;

        }

       $user= User::create($userData);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
           $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
           ]);

           $user = User::where('email',$request->email)->first();

               if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        // Check if user is active
        if(!$user->status){
            return response()->json([
                'message' => 'Your account is deactivated.'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'user' => $user
        ]);

    }

    public function show($id)
    {
        $user= User::findOrFail($id);
        return response()->json(
            [
            'user'=>$user
            ]
          );
    }

   // Update user
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $userData = $request->validated();


        if($request->hasFile('profile_image')){
            $path = $request->file('profile_image')->store('profile_images','public');
            if($user->profile_image){
                Storage::disk('public')->delete($user->profile_image);
            }
            $userData['profile_image'] = $path;
        }

        $user->update($userData);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function logOut(Request $request)
    {
         $request->user()->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logged out successfully']);
    }

    public function destroy($id)
    {
         $user= User::findOrFail($id);
         $user->delete();
            return response()->json([
                'message' => 'User deleted successfully']);
    }
}
