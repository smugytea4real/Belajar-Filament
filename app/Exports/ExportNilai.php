<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportNilai implements FromCollection
{
    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Nilai::where('category_nilai_id', $this->id)->get();
    }
}
