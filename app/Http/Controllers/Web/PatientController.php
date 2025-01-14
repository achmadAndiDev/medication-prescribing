<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\PatientService;
use Illuminate\Http\Request;


class PatientController extends WebManagementController
{
    public function searchOptions(Request $request)
    {
        $filter[] = ['key' => ['name'], 'value' => $request->search];

        $data = $this->service->index(
            page: 1,
            limit: $request->get('limit'),
            sort: [],
            filter: $filter
        );

        $results = $data->map(function ($item) {
            return [
                'id' => $item['id'],    
                'text' => $item['name'],
            ];
        });
    
        return response()->json($results);
    }
}
