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
use App\Http\Resources\ServiceResource;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

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
        return $this->success(DoctorResource::collection($doctors), "doctors fetched successfully");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDoctorRequest $request
     * @return JsonResponse
     */
    public function store(StoreDoctorRequest $request)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $data = $request->validated();
        if (isset($data["photo"])) {
            $data["photo"] = upload_image($data["photo"]);
        }
        $doctor = Doctor::create($data);
        return $this->success(new DoctorResource($doctor));
    }

    /**
     * Display the specified resource.
     *
     * @param Doctor $doctor
     * @return JsonResponse
     */
    public function show(Doctor $doctor)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        return $this->success(new DoctorResource($doctor));
    }

    public function services(Doctor $doctor)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $services = Service::where("doctor_id", $doctor->id)->latest()->get();
        return $this->success(ServiceResource::collection($services));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDoctorRequest $request
     * @param Doctor $doctor
     * @return JsonResponse
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $data = $request->validated();
        if (isset($data["photo"])) {
            $data["photo"] = upload_image($data["photo"]);
        }
        $doctor->update($data);
        return $this->success(new DoctorResource($doctor));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Doctor $doctor
     * @return JsonResponse
     */
    public function destroy(Doctor $doctor)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $doctor->delete();
        return $this->success(true);
    }
}
