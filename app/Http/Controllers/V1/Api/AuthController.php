<?php
/*
 * Project: sunny-backend
 * File: AuthController.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{

    function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        $this->error('auth.failed');

        return back()->withInput();
    }

    /**
     * Create User
     * @param Request $request
     * @return JsonResponse
     */
    public function register(\Illuminate\Http\Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return $this->error($validateUser->errors(), 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);

            return $this->success(
                [
                    "token" => $user->createToken("API TOKEN")->plainTextToken,
                ],
                "user creates successfully");

        } catch (Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
