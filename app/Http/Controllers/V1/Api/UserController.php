<?php
/*
 * Project: sunny-backend
 * File: UserController.php
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
use App\Http\Requests\AddBenefitToUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Benefit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        abort_unless(auth()->user()->isAdmin() , 403);

        $users = User::members()->get();
        return $this->success(UserResource::collection($users), "users fetched successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        abort_unless(auth()->user()->isAdmin() , 403);

        return $this->success(new UserResource($user) , "user fetched successfully");
    }

    /**
     * Store benefit to user.
     *
     * @param AddBenefitToUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function addBenefit(AddBenefitToUserRequest $request , User $user)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $data = $request->validated();

        $benefit = Benefit::select(["unit_price"])->find($data["benefit_id"]);
        $data["unit_price"] = $benefit->unit_price;

        $user->benefits()->syncWithoutDetaching([$data["benefit_id"] => $data]);

        return $this->success(new UserResource($user));
    }

    /**
     * Remove benefit from user.
     *
     * @param User $user
     * @param Benefit $benefit
     * @return JsonResponse
     */
    public function removeBenefit(User $user , Benefit $benefit)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);

        $user->benefits()->detach($benefit->id);

        return $this->success(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
