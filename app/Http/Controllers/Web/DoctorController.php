<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DoctorController extends WebManagementController
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
