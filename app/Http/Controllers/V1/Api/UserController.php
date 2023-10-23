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
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $users = User::members()->paginate(20);
        return UserResource::collection($users);
    }

    /**
     * Display a listing of the resource by role name.
     *
     * @param string $role
     * @return JsonResponse
     */
    public function byRole(string $role)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        if(!in_array($role , Constants::ROLES)){
            return  $this->error("role not correct");
        }

        $users = User::where("role" , $role)->get();
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

        $subscription = Subscription::find($data["subscription_id"]);
        $data["price"] = $subscription->price;
        $data["duration"] = $subscription->duration;
        if(empty($data["end_at"])) {
            $data["end_at"] = Carbon::now()->addMonths(Constants::DURATIONS_IN_MONTHS[$subscription->duration]);
        }

        $user->subscriptions()->sync([$data["subscription_id"] => $data]);

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

        if (isset($data["password"])) {
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
    public function activate(User $user)
    {
        $user->active = true;
        $user->save();
        return $this->success(new UserResource($user));
    }

    /**
     * Active user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function deactivate(User $user)
    {
        $user->active = false;
        $user->save();
        return $this->success(new UserResource($user));
    }


    /**
     * Verify user email.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function verifyEmail(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return $this->error(__("all.email_already_verified"));
        }

        $user->markEmailAsVerified();
        return $this->success(new UserResource($user));
    }

    /**
     * Verify email link
     */
    public function verifyEmailLink($id)
    {
        if (request()->hasValidSignature()) {
            $user = User::find($id);
            $user->markEmailAsVerified();
        }

        return view('user.email-verified');
    }

    /**
     * Unverify user email.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function unVerifyEmail(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            return $this->error(__("all.email_already_un_verified"));
        }

        $user->email_verified_at = null;
        $user->save();
        return $this->success(new UserResource($user));
    }

    /**
     * Send Email Verify of user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function sendEmailVerify(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return $this->error(__("all.email_already_verified"));
        }

        $user->sendEmailVerificationNotification();

        return $this->success(true);
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
