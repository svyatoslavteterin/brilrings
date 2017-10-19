<?php

namespace App\Http\Controllers;

use App\RingImage;
use Illuminate\Http\Request;

class RingImageController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RingImage  $ringImage
     * @return \Illuminate\Http\Response
     */
    public function show(RingImage $ringImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RingImage  $ringImage
     * @return \Illuminate\Http\Response
     */
    public function edit(RingImage $ringImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RingImage  $ringImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RingImage $ringImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RingImage  $ringImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(RingImage $ringImage)
    {
        //
    }

    public function getResultImg($hash){
    
       return \Image::make('images/rings/12421412.jpg')->response('jpg');
    }
}
