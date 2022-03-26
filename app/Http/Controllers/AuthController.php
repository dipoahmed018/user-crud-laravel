<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SigninRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function signinAdmin(SigninRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user || Hash::check($request->password, $user->password)) {
            $token =  $user->createToken('user')->plainTextToken;
            return $this->success(['user' => $user, 'token' => $token], 200);
        } else {
            return $this->failed(['message' => 'Provided credentials are invalid'], 422);
        }
    }

    public function signin(SigninRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user || Hash::check($request->password, $user->password)) {
            $token =  $user->createToken('user')->plainTextToken;
            return $this->success(['user' => $user, 'token' => $token], 200);
        } else {
            return $this->failed(['message' => 'Provided credentials are invalid'], 422);
        }
    }


    public function signup(Request $request)
    {
        $input = $request->only(['name', 'email', 'password']);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User created successfully.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success(['message' => 'Logout successfull']);
    }

    public function logoutForEveryDevice(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->success(['message' => 'Logout from all devices successfull']);
    }
}
