<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Http\Requests\StorePaymentTransactionRequest;
use App\Http\Requests\UpdatePaymentTransactionRequest;

class PaymentTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentTransaction  $paymentTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentTransaction $paymentTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentTransaction  $paymentTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentTransaction $paymentTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentTransactionRequest  $request
     * @param  \App\Models\PaymentTransaction  $paymentTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentTransactionRequest $request, PaymentTransaction $paymentTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentTransaction  $paymentTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentTransaction $paymentTransaction)
    {
        //
    }
}
