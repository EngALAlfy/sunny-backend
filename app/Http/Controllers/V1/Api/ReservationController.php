<?php
/*
 * Project: sunny-backend
 * File: ReservationController.php
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
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $reservations = Reservation::latest()->paginate(20);
        return ReservationResource::collection($reservations);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReservationRequest $request
     * @return JsonResponse
     */
    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();
        $data["status"] = Constants::RESERVATION_WAITING;
        $reservation = Reservation::create($data);

        return $this->success(new ReservationResource($reservation));
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function show(Reservation $reservation)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        return $this->success(new ReservationResource($reservation));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReservationRequest $request
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $data = $request->validated();
        $reservation->update($data);
        return $this->success(new ReservationResource($reservation));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function destroy(Reservation $reservation)
    {
        abort_unless(auth()->user()->isClinicAdmin(), 403);
        $reservation->delete();
        return $this->success(true);
    }
}
