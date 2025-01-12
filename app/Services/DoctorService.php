<?php

namespace App\Services;

use App\Models\Patient;

class DoctorService extends WebManagementService
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

        $query = $this->model->join('persons', 'persons.id', '=', 'doctors.person_id') 
        ->select(
            'persons.name',
            'doctors.*' 
        );

        $query = $query->sortPage($sort, $map)->filterPage($filter, $map);

        return $query->paginate(perPage: $limit, page: $page);
    }

     /**
     * Get field map.
     *
     * @return array
     */
    protected function indexFieldMap()
    {
        return [
            'name' => 'persons.name'
        ];
    }
}
