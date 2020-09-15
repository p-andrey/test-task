<?php

namespace App\Http\Controllers;

use App\Contracts\VinDecoderInterface;
use App\Http\Requests\StolenCarRequest;
use App\Http\Resources\StolenCarResource;
use App\Models\Make;
use App\Models\StolenCar;
use DB;
use Illuminate\Http\Response;

class StolenCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $stolenCars = StolenCar::with('make', 'model')->paginate();

        return StolenCarResource::collection($stolenCars)->response();
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
        DB::transaction(function () use ($request, $vinDecoder) {
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
     * @param  StolenCarRequest  $request
     * @param  int  $id
     * @param  VinDecoderInterface  $vinDecoder
     * @return \Illuminate\Http\JsonResponse|Response
     * @throws \Throwable
     */
    public function update(StolenCarRequest $request, $id, VinDecoderInterface $vinDecoder)
    {
        $stolenCar = StolenCar::findOrFail($id);

        DB::transaction(function () use ($request, $stolenCar, $vinDecoder) {
            $stolenCar = $stolenCar->fill($request->only('name', 'registration_number', 'color', 'vin'));

            if ($stolenCar->isDirty('vin')) {
                $info = $vinDecoder->decode($request->input('vin'));
                $stolenCar->year = $info->year();

                $make = Make::firstOrCreate(['name' => $info->make()]);
                $model = $make->models()->firstOrCreate(['name' => $info->model()]);

                $stolenCar->make()->associate($make);
                $stolenCar->model()->associate($model);
            }

            $stolenCar->save();
        });

        return response()->json([]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $stolenCar = StolenCar::findOrFail($id);
        $stolenCar->delete();

        return response()->json([]);
    }
}
