<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $userObj = new User;
        $userObj->nickname = $request->nickname;
        $userObj->is_private = $request->is_private;
        $userObj->first_name = $request->first_name;
        $userObj->last_name = $request->last_name;
        $userObj->email = $request->email;
        $userObj->password = $request->password;
        $userObj->biography = $request->biography;

        if ($userObj->save()) {
            return ['status' => true, 'message' => "User created successfully"];       
        } else {
            return ['status' => false, 'message' => "An error has occurred while creating the user"];       
        }
    }

    public function read(User $user) {
        return new UserResource($user);
    }
}
