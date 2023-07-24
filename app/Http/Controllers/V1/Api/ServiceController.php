<?php
/*
 * Project: sunny-backend
 * File: ServiceController.php
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
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $services = Service::latest()->get();
        return $this->success(ServiceResource::collection($services));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreServiceRequest $request
     * @return JsonResponse
     */
    public function store(StoreServiceRequest $request)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $data = $request->validated();
        $service = Service::create($data);

        if (isset($data["images"])) {
            foreach ($data["images"] as $image) {
                $file = upload_image($image);
                $service->images()->updateOrCreate(["file" => $file]);
            }
        }

        return $this->success(new ServiceResource($service));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateServiceRequest $request
     * @param Service $service
     * @return JsonResponse
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $data = $request->validated();
        $service->update($data);

        if (isset($data["images"])) {
            // delete old
            $service->images()->delete();
            foreach ($data["images"] as $image) {
                $file = upload_image($image);
                $service->images()->updateOrCreate(["file" => $file]);
            }
        }

        return $this->success(new ServiceResource($service));
    }

    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return JsonResponse
     */
    public function show(Service $service)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        return $this->success(new ServiceResource($service));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Service $service
     * @return JsonResponse
     */
    public function destroy(Service $service)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $service->delete();
        return $this->success(true);
    }
}
