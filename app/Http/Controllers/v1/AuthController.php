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

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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


    function demoLogin()
    {
        $user = User::where('email', 'demo')->first();
        if ($user) {
            Auth::login($user);
            return redirect()->intended('/');
        }

        $this->error("all.no_demo_user");

        return back();
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
