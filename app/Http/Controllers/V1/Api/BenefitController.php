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
use App\Models\Benefit;
use Illuminate\Http\Response;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBenefitRequest $request
     * @return Response
     */
    public function store(StoreBenefitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Benefit $benefit
     * @return Response
     */
    public function show(Benefit $benefit)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBenefitRequest $request
     * @param Benefit $benefit
     * @return Response
     */
    public function update(UpdateBenefitRequest $request, Benefit $benefit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Benefit $benefit
     * @return Response
     */
    public function destroy(Benefit $benefit)
    {
        //
    }
}
