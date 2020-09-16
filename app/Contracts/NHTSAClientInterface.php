<?php

namespace App\Contracts;

interface NHTSAClientInterface
{
    /**
     * @return array
     */
    public function getAllMakes(): array;

    /**
     * @param  int  $makeId
     * @return array
     */
    public function getAllModelsByMakeId(int $makeId): array;
}
