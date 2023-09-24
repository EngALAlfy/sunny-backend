<?php
/*
 * Project: sunny-backend
 * File: PaymentTransactionController.php
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
use App\Http\Requests\StorePaymentTransactionRequest;
use App\Http\Resources\PaymentTransactionResource;
use App\Models\Benefit;
use App\Models\PaymentTransaction;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentTransactionController extends Controller
{

    public function getUserSum(User $user){
        $sum = PaymentTransaction::where("user_id" , $user->id)->sum("value");
        return $this->success($sum);
    }

    public function getAdminSum(User $admin){
        $sum = PaymentTransaction::where("created_by_user_id" , $admin->id)->sum("value");
        return $this->success($sum);
    }
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        $transactions = PaymentTransaction::latest();

        if (request()->has("user_id")) {
            $transactions = $transactions->where("user_id", request()->user_id);
        }

        if (request()->has("payable_id")) {
            $payable_type = request()->payable_type ?? "benefit";
            if (str_contains($payable_type, "benefit")) {
                $payable_type = Benefit::class;
            }

            if (str_contains($payable_type, "subscription")) {
                $payable_type = Subscription::class;
            }

            $transactions = $transactions
                ->where("payable_id", request()->payable_id)
                ->where("payable_type", $payable_type);
        }

        if (request()->has("type")) {
            $transactions = $transactions->where("type", request()->type);
        }

        if (request()->has("created_by_user_id")) {
            $transactions = $transactions->where("created_by_user_id", request()->created_by_user_id);
        }

        if (request()->has("from")) {
            $from = Carbon::parse(request()->from);
            $to = Carbon::parse(request()->to ?? now()->toISOString());

            $transactions = $transactions->whereBetween("created_at", [$from, $to]);
        }


        $transactions = $transactions->paginate(20);
        return PaymentTransactionResource::collection($transactions);
    }

    public function show(PaymentTransaction $paymentTransaction)
    {
        abort_unless(auth()->user()->isAdmin(), 403);
        return new PaymentTransactionResource($paymentTransaction);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StorePaymentTransactionRequest $request
     * @return PaymentTransactionResource
     */
    public function store(StorePaymentTransactionRequest $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $data = $request->validated();
        $data["created_by_user_id"] = auth()->id();

        if (isset($data["type"])) {
            $type = $data["type"];
            if (str_contains($type, "benefit")) {
                $data["payable_type"] = Benefit::class;
            }

            if (str_contains($type, "subscription")) {
                $data["payable_type"] = Subscription::class;
            }
        }

        $transaction = PaymentTransaction::create($data);
        return new PaymentTransactionResource($transaction);
    }

}
