<?php

namespace App\Http\Controllers;

use App\Exports\ExportNilai;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export()
    {
        $categoryId = request('tableFilters.category_nilai_id.value');

        return Excel::download(new ExportNilai($categoryId), 'Nilai.xlsx');

        // return 'Hello Export Category:'. $categoryId;
    }
}
