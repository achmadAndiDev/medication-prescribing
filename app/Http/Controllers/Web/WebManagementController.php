<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Throwable;

class WebManagementController extends Controller
{
    protected $resource;
    protected $service;
    protected $viewFolder = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (empty($this->resource)) {
            $this->resource = Str::kebab(Str::plural(Str::before(class_basename($this), 'Controller')));
        }
        if (empty($this->serviceClass)) {
            $this->service = App::make('\App\Services\\' . Str::studly(Str::singular($this->resource)) . 'Service');
        }

        if ($this->viewFolder == false) {
            $this->viewFolder = 'common';
        } else if (empty($this->viewFolder)) {
            $this->viewFolder = Str::snake($this->resource);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // header
        $header = array_values(static::defineIndexHeader());
        $filterableHeaders = static::defineFilterableHeaders();

        // data, default sort kolom pertama
        $sortIndex = 0;
        $sortDirection = 0;

        $sort = [
            ['key' => $header[$sortIndex]['field'], 'direction' => $sortDirection ? 'desc' : 'asc']
        ];

        $search = $request->get('search');

        $filter = [];
        if ($request->field == 'all') {
            $keys = [];
            foreach ($filterableHeaders as $v) {
                $keys[] = $v['field'];
            }
            $filter[] = ['key' => $keys, 'value' => $search];
        } 
        
        if(in_array($request->field, array_keys($filterableHeaders))) {
            $filter[] = ['key' => $request->field, 'value' => $search];
        }

        $data = $this->service->index(
            page: $request->get('page'),
            limit: $request->get('limit'),
            sort: $sort,
            filter: $filter
        );

        return view('pages.' . $this->viewFolder . '.index', [
            'data' => $data,
            'header' => $header,
            'filterableHeaders' => $filterableHeaders,
            'search' => $search,
            'sortDirection' => $sortDirection,
            'sortIndex' => $sortIndex,
            'resource' => $this->resource,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // echo json_encode([static::defineFormInputs()]);
        // die;
        return view('pages.' . $this->viewFolder . '.form', [
            'content' => static::defineFormInputs(),
            'resource' => $this->resource
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $files = $this->inputFiles($request);
            if (!empty($files['is_error']) && $files['is_error']) {
                throw new \Exception($files['message']);
            }

            $params = $request->post();
            if (!empty($files['data'])) {
                foreach ($files['data'] as $fieldName => $value) {
                    $params[$fieldName] = $value;
                }
            }

            // Insert created_by jika tabelnya punya
            $tableName = with($this->service->model)->getTable();
            if (Schema::hasColumn($tableName, 'created_by')) {
                $params['created_by'] = auth()->id(); 
            }

            $data = $this->service->store($params);
        } catch (Throwable $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(route($this->resource . '.index', [Str::singular(str_replace('-', '_', $this->resource)) => $data->id]))->with('success', 'Berhasil menambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = $this->service->show($id);

        $data = [];
        foreach (static::defineFormInputs(true) as $k => $v) {
            $field = $v['value_field'] ?? $k;
            $data[$k] = $model->$field;
        }

        // echo json_encode($data);
        // die;

        return view('pages.' . $this->viewFolder . '.show', [
            'id' => $model->id,
            'data' => $data,
            'resource' => $this->resource
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = $this->service->show($id);

        $content = static::defineFormInputs();
        foreach ($content as $k => $v) {
            $content[$k]['value'] = $model->$k;
        }

        return view('pages.' . $this->viewFolder . '.form', [
            'id' => $model->id,
            'content' => $content,
            'resource' => $this->resource
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $files = $this->inputFiles($request);
            if (!empty($files['is_error']) && $files['is_error']) {
                throw new \Exception($files['message']);
            }

            $params = $request->post();
            if (!empty($files['data'])) {
                foreach ($files['data'] as $fieldName => $value) {
                    $params[$fieldName] = $value;
                }
            }

            $data = $this->service->update($params, $id);
        } catch (Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->to(route($this->resource . '.index', [Str::singular(str_replace('-', '_', $this->resource)) => $data->id]))->with('success', 'Berhasil merubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->destroy($id);

        return back()->with('success', Lang::get($this->resource.".title") . ' berhasil di hapus');
    }

    public function importDownloadTemplate()
    {
        $fileName = $this->resource.'-template.xlsx';

        $templatePath = public_path('templates/'.$fileName);

        return response()->download($templatePath);
    }

    /**
     * Get resource list header.
     */
    protected function defineIndexHeader()
    {
        $header = [];
        foreach ($this->service->model::RULES as $k => $v) {
            $header[$k] = ['field' => $k, 'label' => __($this->resource . '.' . $k), 'sortable' => true];
        }

        return $header;
    }

    /**
     * Get resource list header.
     */
    protected function defineFilterableHeaders()
    {
        $header = [];
        foreach ($this->service->model::FILTERABLE as $k) {
            $header[$k] = ['field' => $k, 'label' => __($this->resource . '.' . $k)];
        }

        return $header;
    }

    /**
     * Get resource form inputs.
     */
    protected function defineFormInputs(bool $readOnly = false, bool $isEdit = false)
    {
        $inputs = [];
        foreach ($this->service->model::RULES as $k => $v) {
            $label = __($this->resource . '.' . $k);
            $inputs[$k] = [
                'id' => $k,
                'name' => $k,
                'label' => $label,
                'placeholder' => 'Masukkan ' . $label . (empty($v['required']) ? ' (opsional)' : ''),
                'data-cy' => $k,
            ] + $v;
        }

        return $inputs;
    }

    protected function inputFiles(Request $request)
    {
        $className = class_basename($this->service->model::class);
        if (!defined('App\Models\\' . $className . '::FILE_LOCATION_DIR')) {
            return [];
        }

        $fileUploads = $this->service->model::FILE_LOCATION_DIR;

        $isError = false;
        $message = '';
        $imageNames = [];
        foreach ($fileUploads as $fieldName => $prop) {
            if (!$request->hasFile($fieldName)) {
                continue;
            }

            if (is_array($request->file($fieldName))) {
                foreach ($request->file($fieldName) as $idx => $file) {
                    $validator = Validator::make([
                        $fieldName => $file
                    ], [
                        $fieldName => $prop['validation'],
                    ]);

                    if ($validator->fails()) {
                        $isError = true;
                        $message = $validator->errors();
                        break 2;
                    }

                    $imageName = $className . '_' .  Carbon::now()->format('YmdHis') . $idx . '.' . $file->extension();
                    $file->move(public_path($prop['dir']), $imageName);

                    if (array_key_exists($fieldName, $imageNames)) {
                        array_push($imageNames[$fieldName], $imageName);
                    } else {
                        $imageNames[$fieldName] = [$imageName];
                    }
                }
            } else {
                $validator = Validator::make($request->all(), [
                    $fieldName => $prop['validation'],
                ]);

                if ($validator->fails()) {
                    $isError = true;
                    $message = $validator->errors();
                    break;
                }
                $image = $request->file($fieldName);
                $imageName = $className . '_' .  Carbon::now()->format('YmdHis') . '.' . $image->extension();
                $image->move(public_path($prop['dir']), $imageName);

                $imageNames[$fieldName] = $imageName;
            }
        }

        return [
            'is_error' => $isError,
            'message' => $message,
            'data' => $imageNames
        ];
    }
}
