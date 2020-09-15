<?php

namespace App\Contracts;

interface VinDecoderInterface
{
    /**
     * @param  string  $vin
     * @return $this
     */
    public function decode(string $vin): VinDecoderInterface;

    /**
     * @return string|null
     */
    public function make(): ?string;

    /**
     * @return string|null
     */
    public function model(): ?string;

    /**
     * @return int|null
     */
    public function year(): ?int;
}
