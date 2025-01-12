<?php

namespace App\Services;

use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class PrescriptionService extends WebManagementService
{
    /**
     * Get prescription data by examination ID with detailed aggregation.
     *
     * @param int $examinationId
     * @param int $page
     * @param array $sort
     * @param array $filter
     * @param int $limit
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPrescriptionsByExaminationId(
        int $examinationId, 
        int $page = 1, 
        array $sort = [], 
        array $filter = [], 
        int $limit = 10
    ) {
        $limit = max(1, min($limit, 100)); 
        
        $query = $this->model
            ->join('prescription_details as pd', 'prescriptions.id', '=', 'pd.prescription_id')
            ->select(
                'prescriptions.id',
                'prescriptions.prescription_date',
                'prescriptions.notes',
                'prescriptions.is_paid',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(pd.quantity * pd.unit_price) as total_price')
            )
            ->where('prescriptions.examination_id', $examinationId)
            ->groupBy('prescriptions.id', 'prescriptions.prescription_date', 'prescriptions.notes', 'prescriptions.is_paid');

        foreach ($filter as $field => $value) {
            $query->where($field, $value);
        }

        foreach ($sort as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query->paginate(perPage: $limit, page: $page);
    }

}
