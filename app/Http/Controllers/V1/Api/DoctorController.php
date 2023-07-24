<?php
/*
 * Project: sunny-backend
 * File: DoctorController.php
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
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $doctors = Doctor::latest()->get();
        return $this->success(DoctorResource::collection($doctors) , "");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDoctorRequest $request
     * @return Response
     */
    public function store(StoreDoctorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Doctor $doctor
     * @return Response
     */
    public function show(Doctor $doctor)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDoctorRequest $request
     * @param Doctor $doctor
     * @return Response
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Doctor $doctor
     * @return Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
