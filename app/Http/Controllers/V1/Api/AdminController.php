<?php
/*
 * Project: sunny-backend
 * File: AdminController.php
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
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);
        $admins = User::admins()->paginate(20);
        return $this->success(UserResource::collection($admins));
    }

    public function roles()
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $roles = request()->has("all") ? Constants::ROLES : Constants::ADMIN_ROLES;
        return $this->success($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdminRequest $request
     * @return JsonResponse
     */
    public function store(StoreAdminRequest $request)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);
        $data = $request->validated();
        if (isset($data["photo"])) {
            $data["photo"] = upload_image($data["photo"]);
        }
        $data["password"] = Hash::make($data["password"]);
        $data["active"] = true;
        $admin = User::create($data);
        $admin->markEmailAsVerified();
        return $this->success(new UserResource($admin));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $admin)
    {
        abort_unless(auth()->user()->isSuperAdmin() || $admin->id == auth()->id(), 403);
        return $this->success(new UserResource($admin));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdminRequest $request
     * @param User $admin
     * @return JsonResponse
     */
    public function update(UpdateAdminRequest $request, User $admin)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);
        $data = $request->validated();

        if(isset($data["password"])){
            $data["password"] = Hash::make($data["password"]);
        }

        if (isset($data["photo"])) {
            $data["photo"] = upload_image($data["photo"]);
        }

        $data["active"] = true;
        $admin->update($data);
        return $this->success(new UserResource($admin));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $admin
     * @return JsonResponse
     */
    public function destroy(User $admin)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);

        if($admin->id == auth()->id()){
            return $this->error("you can not delete yourself" , 402);
        }

        $admin->delete();

        return $this->success(true);
    }
}
