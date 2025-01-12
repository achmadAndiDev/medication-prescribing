<?php

namespace App\Services;

use App\Models\Patient;

class ExaminationService extends WebManagementService
{
    /**
     * Display a listing of the resource with options.
     *
     * @param int $page
     * @param array $sort
     * @param array $filter
     * @param int $limit
     *
     * @return mixed
     */
    public function index(int $page = null, array $sort = [], array $filter = [], int $limit = null)
    {
        if (empty($page)) {
            $page = 1;
        }

        if (empty($limit) || $limit < 0) {
            $limit = 10;
        } else if ($limit > 100) {
            $limit = 100;
        }

        $map = static::indexFieldMap();

        // return $this->indexModel()->sortPage($sort, $map)->filterPage($filter, $map)->paginate(perPage: $limit, page: $page);

        $query = $this->model->join('patients', 'patients.id', '=', 'examinations.patient_id')
        ->join('doctors', 'doctors.id', '=', 'examinations.doctor_id')
        ->join('persons', 'persons.id', '=', 'doctors.person_id') 
        ->select(
            'patients.name as patient_name',
            'persons.name as doctor_name',
            'examinations.*' 
        );

        $query = $query->sortPage($sort, $map)->filterPage($filter, $map);

        return $query->paginate(perPage: $limit, page: $page);
    }

     /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function show(int $id)
    {
        return $this->responseModel()->join('patients', 'patients.id', '=', 'examinations.patient_id')
        ->join('doctors', 'doctors.id', '=', 'examinations.doctor_id')
        ->join('persons', 'persons.id', '=', 'doctors.person_id') 
        ->select(
            'patients.name as patient_name',
            'persons.name as doctor_name',
            'examinations.*' 
        )->findOrFail($id);
    }
}
