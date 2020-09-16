<?php

namespace App;

use App\Contracts\NHTSAClientInterface;
use Illuminate\Support\Facades\Http;

class NHTSAClient implements NHTSAClientInterface
{
    protected const URL = 'https://vpic.nhtsa.dot.gov/api/';

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllMakes(): array
    {
        $response = Http::baseUrl(static::URL)->get("vehicles/getallmakes", ['format' => 'json']);

        if (!$response->successful() || $response->json('Count') === 0) {
            throw new \Exception('Can`t get all makes');
        }

        return collect($response->json('Results'))
            ->map(function ($item) {
                return [
                    'id' => $item['Make_ID'],
                    'name' => $item['Make_Name'],
                ];
            })->toArray();
    }

    /**
     * @param  int  $makeId
     * @return array
     * @throws \Exception
     */
    public function getAllModelsByMakeId(int $makeId): array
    {
        $response = Http::baseUrl(static::URL)->get("vehicles/getmodelsformakeid/{$makeId}", ['format' => 'json']);

        if (!$response->successful()) {
            throw new \Exception('Can`t get models by make id[' . $makeId . ']');
        }

        if ($response->json('Count') === 0) {
            return [];
        }

        return collect($response->json('Results'))
            ->map(function ($item) {
                return [
                    'id' => $item['Model_ID'],
                    'name' => $item['Model_Name'],
                ];
            })->toArray();
    }
}
