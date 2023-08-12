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
use App\Http\Helpers\Constants;
use App\Http\Requests\AddBenefitToUserRequest;
use App\Http\Requests\AddSubscriptionToUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Benefit;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

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
        abort_unless(auth()->user()->isAdmin(), 403);

        return $this->success(new UserResource($user), "user fetched successfully");
    }

    /**
     * Store benefit to user.
     *
     * @param AddBenefitToUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function addBenefit(AddBenefitToUserRequest $request, User $user)
    {
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
    public function removeBenefit(User $user, Benefit $benefit)
    {
        $user->benefits()->detach($benefit->id);

        return $this->success(new UserResource($user));
    }

    /**
     * Store subscription to user.
     *
     * @param AddBenefitToUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function addSubscription(AddSubscriptionToUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($user->subscriptions()->where("subscriptions.id", $data["subscription_id"])->exists()) {
            return $this->error(__("all.subscription_already_added"));
        }
        $subscription = Subscription::find($data["subscription_id"]);
        $data["price"] = $subscription->price;
        $data["duration"] = $subscription->duration;
        $data["end_at"] = Carbon::now()->addMonths(Constants::DURATIONS_IN_MONTHS[$subscription->duration]);

        $user->subscriptions()->syncWithoutDetaching([$data["subscription_id"] => $data]);

        // get subscription benefits
        $benefits = $subscription->benefits;
        // check if user already have one or more benefit
        foreach ($benefits as $benefit) {
            $userBenefit = $user->benefits()->where("benefits.id", $benefit->id)->first();

            if (empty($userBenefit)) {
                $benefitData["limit"] = $benefit->pivot->limit;
            } else {
                $benefitData["limit"] = intval($userBenefit->pivot->limit) + intval($benefit->pivot->limit);
            }

            $benefitData["unit_price"] = $benefit->pivot->unit_price;
            $user->benefits()->syncWithoutDetaching([$benefit->id => $benefitData]);
        }

        return $this->success(new UserResource($user));
    }

    /**
     * Remove subscription from user.
     *
     * @param User $user
     * @param Subscription $subscription
     * @return JsonResponse
     */
    public function removeSubscription(User $user, Subscription $subscription)
    {

        $user->subscriptions()->detach($subscription->id);
        // get subscription benefits
        $benefits = $subscription->benefits;

        $user->benefits()->detach($benefits);
        return $this->success(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        abort_unless(auth()->user()->isAdmin() || auth()->id() == $user->id, 403);
        $data = $request->validated();

        if(isset($data["password"])){
            $data["password"] = Hash::make($data["password"]);
        }

        if (isset($data["photo"])) {
            $data["photo"] = upload_image($data["photo"]);
        }

        $user->update($data);
        return $this->success(new UserResource($user));
    }

    /**
     * Active user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function active(User $user)
    {
        $user->active = true;
        $user->save();
        return $this->success(new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);

        if ($user->id == auth()->id()) {
            return $this->error("you can not delete yourself", 402);
        }

        $user->delete();

        return $this->success(true);
    }
}
