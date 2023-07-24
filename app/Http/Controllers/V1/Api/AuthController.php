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
use App\Http\Helpers\Constants;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{

    /**
     * Login member or admins
     * @header Content-Type application/json
     * @header Accept application/json
     * @header Accept-Language en
     * @bodyParam email string required The email of user
     * @bodyParam password string required The password of user
     * @param LoginRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            return $this->success(
                [
                    "token" => UserService::generateUserToken(),
                ],
                "user login successfully");
        }

        $this->error('auth.failed', 401);

        return back()->withInput();
    }

    /**
     * Create User
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required|max:200',
                    'username' => 'required|unique:users,username|max:100|min:3',
                    'email' => 'required|email|unique:users,email|max:200',
                    'password' => 'required|max:200|min:4',
                    'phone' => 'nullable|unique:users,phone|max:13',
                    'photo' => 'nullable|image|max:800',
                    'role' => 'nullable|in:' . Constants::ROLE_MEMBER,
                ]);

            if ($validateUser->fails()) {
                return $this->error($validateUser->errors(), 401);
            }

            $data = $validateUser->validated();

            if (isset($data["photo"])) {
                $data["photo"] = upload_image($data["photo"]);
            }

            $data["password"] = Hash::make($data["password"]);

            $user = User::create($data);

            return $this->success(
                [
                    "token" => UserService::generateUserToken($user),
                ],
                "user creates successfully");

        } catch (Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    /**
     * Get Authed user data
     * @return JsonResponse
     */
    public function profile()
    {
        return $this->success(new UserResource(auth()->user()), "user fetched successfully");
    }
}
