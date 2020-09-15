<?php

namespace App;

use App\Contracts\VinDecoderInterface;
use Illuminate\Support\Facades\Http;

class NHTSAVinDecoder implements VinDecoderInterface
{
    protected const URL = 'https://vpic.nhtsa.dot.gov/api/';

    protected $make;

    protected $model;

    protected $year;

    /**
     * @param  string  $vin
     * @return $this
     * @throws \Exception
     */
    public function decode(string $vin): VinDecoderInterface
    {
        $response = Http::baseUrl(static::URL)->get("vehicles/DecodeVinValues/{$vin}", ['format' => 'json']);
        if (!$response->successful() || $response->json('Count') === 0) {
            throw new \Exception('Can`t decode VIN');
        }

        $this->make = $response->json('Results.0.Make');
        $this->model = $response->json('Results.0.Model');
        $this->year = (int)$response->json('Results.0.ModelYear');

        return $this;
    }

    /**
     * @return string|null
     */
    public function make(): ?string
    {
        return $this->make;
    }

    /**
     * @return string|null
     */
    public function model(): ?string
    {
        return $this->model;
    }

    /**
     * @return int|null
     */
    public function year(): ?int
    {
        return $this->year;
    }
}
