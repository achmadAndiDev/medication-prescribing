<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\PrescriptionService;
use Illuminate\Http\Request;

class PrescriptionController extends WebManagementController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $prescription = $this->service->store($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Prescription and details saved successfully.',
                'data' => $prescription,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the prescription.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
