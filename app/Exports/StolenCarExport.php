<?php

namespace App\Exports;

use App\Models\StolenCar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class StolenCarExport implements FromCollection, WithMapping
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * StolenCarExport constructor.
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return StolenCar::with('make', 'model')
            ->filter($this->request->all())
            ->sort($this->request->all())
            ->get();
    }

    /**
     * @param  StolenCar  $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
            'registration_number' => $row->registration_number,
            'color' => $row->color,
            'vin' => $row->vin,
            'year' => $row->year,
            'make' => $row->make->name,
            'model' => $row->model->name,
        ];
    }
}
