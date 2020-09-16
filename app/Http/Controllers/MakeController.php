<?php

namespace App\Http\Controllers;

use App\Contracts\NHTSAClientInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MakeController extends Controller
{
    /**
     * @param  Request  $request
     * @param  NHTSAClientInterface  $NHTSAClient
     * @return \Illuminate\Http\JsonResponse
     */
    public function makesAutocomplete(Request $request, NHTSAClientInterface $NHTSAClient)
    {
        $sentence = mb_strtolower($request->input('sentence'));
        if (!$sentence) {
            return response()->json(['makes' => []]);
        }

        $allMakes = \Cache::remember('makes', now()->addHour(), function () use ($NHTSAClient) {
            return $NHTSAClient->getAllMakes();
        });

        $result = collect($allMakes)->filter(function ($item) use ($sentence) {
            return Str::startsWith(mb_strtolower($item['name']), $sentence);
        });

        return response()->json(['makes' => $result->values()->toArray()]);
    }

    /**
     * @param $makeId
     * @param  NHTSAClientInterface  $NHTSAClient
     * @return \Illuminate\Http\JsonResponse
     */
    public function getModels($makeId, NHTSAClientInterface $NHTSAClient)
    {
        try {
            $models = $NHTSAClient->getAllModelsByMakeId($makeId);
        } catch (\Exception $e) {
            $models = [];
        }

        return response()->json(compact('models'));
    }
}
