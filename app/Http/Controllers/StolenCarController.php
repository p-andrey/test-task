<?php

namespace App\Http\Controllers;

use App\Contracts\VinDecoderInterface;
use App\Http\Requests\StolenCarRequest;
use App\Models\Make;
use App\Models\StolenCar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StolenCarController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  StolenCarRequest  $request
     * @param  VinDecoderInterface  $vinDecoder
     * @return \Illuminate\Http\JsonResponse|Response
     * @throws \Throwable
     */
    public function store(StolenCarRequest $request, VinDecoderInterface $vinDecoder)
    {
        \DB::transaction(function () use ($request, $vinDecoder) {
            $info = $vinDecoder->decode($request->input('vin'));

            $stolenCar = new StolenCar($request->only('name', 'registration_number', 'color', 'vin'));

            $stolenCar->year = $info->year();

            $make = Make::firstOrCreate(['name' => $info->make()]);
            $model = $make->models()->firstOrCreate(['name' => $info->model()]);

            $stolenCar->make()->associate($make);
            $stolenCar->model()->associate($model);

            $stolenCar->save();
        });

        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
