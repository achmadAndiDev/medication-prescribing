<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\PatientService;
use Illuminate\Http\Request;

class ExaminationController extends WebManagementController
{
    /**
     * Get resource list header.
     */
    protected function defineIndexHeader()
    {
        $header = [];
        
        $header['patient_id'] = ['field' => 'patient_id', 'label' => __($this->resource . '.patient_id'), 'sortable' => true];
        $header['patient_name'] = ['field' => 'patient_name', 'label' => __($this->resource . '.patient_name'), 'sortable' => true];
        $header['doctor_id'] = ['field' => 'doctor_id', 'label' => __($this->resource . '.doctor_id'), 'sortable' => true];
        $header['doctor_name'] = ['field' => 'doctor_name', 'label' => __($this->resource . '.doctor_name'), 'sortable' => true];
        $header['examination_time'] = ['field' => 'examination_time', 'label' => __($this->resource . '.examination_time'), 'sortable' => true];
        $header['status'] = ['field' => 'status', 'label' => __($this->resource . '.status'), 'sortable' => true];

        return $header;
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

            if(isset($v['control']) && $v['control'] == 'select-search-ajax') {
                $selectedText = str_replace('_id', '_name', $k);
                $content[$k]['selected_text'] = $model->$selectedText;
            }
        }
    
        return view('pages.' . $this->viewFolder . '.form', [
            'id' => $model->id,
            'content' => $content,
            'resource' => $this->resource
        ]);
    }

    protected function customView($data, $isShow = false)
    {
        if ($isShow) {
            $data['status'] = $this->service->model::STATUSES[$data['status']];
            $data['examination_time'] = date('d F Y, H:i', strtotime($data['examination_time']));

            return $data;
        }

        foreach($data as $key => $item)
        {
            $data[$key]['status'] = $this->service->model::STATUSES[$item['status']];
        }

        return $data;
    }
}
