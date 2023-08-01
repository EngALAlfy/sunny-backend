<?php
/*
 * Project: sunny-backend
 * File: BenefitController.php
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
use App\Http\Requests\StoreBenefitRequest;
use App\Http\Requests\UpdateBenefitRequest;
use App\Http\Resources\BenefitResource;
use App\Models\Benefit;
use Illuminate\Http\JsonResponse;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $benefits = Benefit::latest()->get();
        return $this->success(BenefitResource::collection($benefits));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBenefitRequest $request
     * @return JsonResponse
     */
    public function store(StoreBenefitRequest $request)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $data = $request->validated();
        $benefit = Benefit::create($data);

        return $this->success(new BenefitResource($benefit));
    }

    /**
     * Display the specified resource.
     *
     * @param Benefit $benefit
     * @return JsonResponse
     */
    public function show(Benefit $benefit)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        return $this->success(new BenefitResource($benefit));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBenefitRequest $request
     * @param Benefit $benefit
     * @return JsonResponse
     */
    public function update(UpdateBenefitRequest $request, Benefit $benefit)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $data = $request->validated();
        $benefit->update($data);

        return $this->success(new BenefitResource($benefit));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Benefit $benefit
     * @return JsonResponse
     */
    public function destroy(Benefit $benefit)
    {
        abort_unless(auth()->user()->isGymAdmin(), 403);
        $benefit->delete();
        return $this->success(true);
    }
}
