<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $users = User::orderBy('id')->exceptAdmin()->cursorPaginate($limit);
        return $this->success($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $inputs = $request->only(['name', 'email', 'password']);
        $inputs['password'] = bcrypt($inputs['password']);
        $inputs['email_verified_at'] = $request->verified ? Date::now() : null;
        $user = User::create($inputs);
        return $this->success($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->success($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $inputs = $request->only(['name','email', 'password']);
        return $inputs;
        $inputs['password'] = !$inputs['password'] ?? bcrypt($inputs['password']);
        $inputs['email_verified_at'] = $request->verified ? Date::now() : null;
        $user->update($inputs);
        return $this->success($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    }

    public function email(Request $request, User $user)
    {
        $user->notify(new WelcomeNotification());
    }
}
