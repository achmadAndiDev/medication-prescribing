<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebManagementService
{
    public $model;

    protected $selectTextField = 'id';

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (empty($this->model)) {
            $this->model = App::make('\App\Models\\' . Str::before(class_basename($this), 'Service'));
        }
    }

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
        // dd($this->indexModel()->sortPage($sort, $map)->filterPage($filter, $map)->toSql());

        return $this->indexModel()->sortPage($sort, $map)->filterPage($filter, $map)->paginate(perPage: $limit, page: $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data)
    {
        $model = DB::transaction(function () use ($data) {
            return $this->model->create($data);
        });

        return $this->find($model->id);
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
        return $this->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param array $data
     * @param int $id
     *
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $model = $this->find($id);

        DB::transaction(function () use ($model, $data) {
            $model->update($data);
        });

        return $this->find($model->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $model = $this->find($id);

        DB::transaction(function () use ($model) {
            $model->delete();
        });
    }

    /**
     * Display a listing of the resource for dropdown.
     *
     * @return array
     */
    public function indexSelect()
    {
        $text = $this->selectTextField;

        return $this->model->select(['id', $text])->orderBy($text)->pluck($text, 'id')->toArray();
    }

    /**
     * Find target.
     *
     * @param int $id
     *
     * @return mixed
     */
    protected function find(int $id)
    {
        return $this->responseModel()->findOrFail($id);
    }

    /**
     * Model for response.
     *
     * @return mixed
     */
    protected function responseModel()
    {
        return $this->model;
    }

    /**
     * Model for index.
     *
     * @return mixed
     */
    protected function indexModel()
    {
        return $this->responseModel();
    }

    /**
     * Get field map.
     *
     * @return array
     */
    protected function indexFieldMap()
    {
        return [];
    }
}
