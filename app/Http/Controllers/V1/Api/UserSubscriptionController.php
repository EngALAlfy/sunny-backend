<?php
/*
 * Project: sunny-backend
 * File: SubscriptionController.php
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
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(User $user)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $subscriptions = $user->subscriptions()->latest()->get();
        return $this->success(SubscriptionResource::collection($subscriptions));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @param StoreSubscriptionRequest $request
     * @return JsonResponse
     */
    public function store(User $user , StoreSubscriptionRequest $request)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $data = $request->validated();

        $subscription = Subscription::create($data);

        return $this->success(new SubscriptionResource($subscription));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param Subscription $subscription
     * @return JsonResponse
     */
    public function destroy(User $user , Subscription $subscription)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $user->subscriptions()->detach($subscription->id);
        return $this->success(true);
    }
}
