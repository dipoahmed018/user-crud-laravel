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
            return $this->success("Login Successful", 200, ['user' => $user, 'token' => $token]);
        } else {
            return $this->failed('Provided credentials are invalid', 422);
        }
    }

    public function signin(SigninRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user || Hash::check($request->password, $user->password)) {
            $token =  $user->createToken('user')->plainTextToken;
            return $this->success("Login successful", 200, ['user' => $user, 'token' => $token]);
        } else {
            return $this->failed('Provided credentials are invalid', 422);
        }
    }


    public function signup(Request $request)
    {
        $input = $request->only(['name', 'email', 'password']);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user['token'] =  $user->createToken('user')->plainTextToken;

        return $this->success('User creation successfull', 201, $user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success('Logout successfull');
    }

    public function logoutForEveryDevice(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->success('Logout from all devices successfull');
    }
}
