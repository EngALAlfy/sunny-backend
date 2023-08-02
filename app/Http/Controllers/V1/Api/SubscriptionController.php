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
use App\Http\Requests\AddBenefitToSubscriptionRequest;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Benefit;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $subscriptions = Subscription::latest()->get();
        return $this->success(SubscriptionResource::collection($subscriptions));
    }

    /**
     * Store benefit to subscription.
     *
     * @param AddBenefitToSubscriptionRequest $request
     * @param Subscription $subscription
     * @return JsonResponse
     */
    public function addBenefit(AddBenefitToSubscriptionRequest $request , Subscription $subscription)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $data = $request->validated();

        $benefit = Benefit::select(["unit_price"])->find($data["benefit_id"]);
        $data["unit_price"] = $benefit->unit_price;

        $subscription->benefits()->syncWithoutDetaching([$data["benefit_id"] => $data]);

        return $this->success(new SubscriptionResource($subscription));
    }

    /**
     * Remove benefit from subscription.
     *
     * @param Subscription $subscription
     * @param Benefit $benefit
     * @return JsonResponse
     */
    public function removeBenefit(Subscription $subscription , Benefit $benefit)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);

        $subscription->benefits()->detach($benefit->id);

        return $this->success(new SubscriptionResource($subscription));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSubscriptionRequest $request
     * @return JsonResponse
     */
    public function store(StoreSubscriptionRequest $request)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $data = $request->validated();
        if (isset($data["photo"])) {
            $data["photo"] = upload_image($data["photo"]);
        }

        $subscription = Subscription::create($data);

        return $this->success(new SubscriptionResource($subscription));
    }

    /**
     * Display the specified resource.
     *
     * @param Subscription $subscription
     * @return JsonResponse
     */
    public function show(Subscription $subscription)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        return $this->success(new SubscriptionResource($subscription));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSubscriptionRequest $request
     * @param Subscription $subscription
     * @return JsonResponse
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $data = $request->validated();
        if (isset($data["photo"])) {
            $data["photo"] = upload_image($data["photo"]);
        }

        $subscription->update($data);

        return $this->success(new SubscriptionResource($subscription));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscription $subscription
     * @return JsonResponse
     */
    public function destroy(Subscription $subscription)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $subscription->delete();
        return $this->success(true);
    }
}
