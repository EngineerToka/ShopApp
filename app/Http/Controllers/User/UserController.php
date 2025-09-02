<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users= User::paginate(10);

         return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully.',
            'data' => UserResource::collection($users)
        ]);
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
            'success' => true,
            'message' => 'Users created successfully.',
            'data' => UserResource::collection($user)
        ], 201);
    }

    public function login(Request $request)
    {
           $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
           ]);

           $user = User::where('email',$request->email)->first();


           if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'message' => 'The provided credentials are incorrect.'
        ], 401);
    }

    // Check if user is active
    if (!$user->status) {
        return response()->json([
            'status' => 'error',
            'message' => 'Your account is deactivated.'
        ], 403);
    }

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Login successful',
            'data' => [
                'access_token' => $token,
                'user'=> new UserResource($user),
                ]
        ]);

    }

    public function show($id)
    {
        $user= User::findOrFail($id);

          return response()->json([
            'success' => true,
            'message' => 'User retrieved successfully.',
            'data' => new UserResource($user)
        ]);
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
            'success' => true,
            'message' => 'User updated successfully.',
            'data' => new UserResource($user)
        ]);
    }

    public function logOut(Request $request)
    {
         $request->user()->currentAccessToken()->delete();
 
                return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.'
        ]);
    }

    public function destroy($id)
    {
         $user= User::findOrFail($id);
         $user->delete();
            return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);

                
    }
}
