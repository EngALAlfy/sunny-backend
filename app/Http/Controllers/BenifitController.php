<?php

namespace App\Http\Controllers;

use App\Models\Benifit;
use App\Http\Requests\StoreBenifitRequest;
use App\Http\Requests\UpdateBenifitRequest;

class BenifitController extends Controller
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
     * @param  \App\Http\Requests\StoreBenifitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBenifitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Benifit  $benifit
     * @return \Illuminate\Http\Response
     */
    public function show(Benifit $benifit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Benifit  $benifit
     * @return \Illuminate\Http\Response
     */
    public function edit(Benifit $benifit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBenifitRequest  $request
     * @param  \App\Models\Benifit  $benifit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBenifitRequest $request, Benifit $benifit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Benifit  $benifit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Benifit $benifit)
    {
        //
    }
}
