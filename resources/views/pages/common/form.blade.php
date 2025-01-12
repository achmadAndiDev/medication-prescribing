@php
if (!empty($resource)) {
    if (empty($title)) {
        $title = Lang::get(Str::snake($resource) . '.title');
    }
}
$formTitle = isset($id) ? 'Ubah':'Tambah';
@endphp

@extends('layouts.main')

@section('title', $formTitle.' '.$title) 
@push('stylesheets')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1> {{-- Perbarui the heading --}}

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route($resource.'.index') }}">{{ $title }}</a></li> {{-- Perbarui route --}}
                <li class="breadcrumb-item active" aria-current="page">{{ $formTitle }}</li>
            </ol>
        </nav>
    </div>

    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow ">
                    <div class="card-header d-sm-flex align-items-center justify-content-between ">
                        <h6 class="m-0 font-weight-bold text-primary">Data Kategori</h6> {{-- Perbarui the heading --}}
                    </div>
                    <div class="card-body">
                        <form method="POST" 
                            action="{{ isset($id) ? route($resource . '.update', $id) : route($resource . '.store') }}" 
                            enctype="multipart/form-data">

                            @csrf
                            @if(isset($id))
                                @method('PUT') 
                            @endif
                            @foreach($content as $field => $attributes)
                                <div class="form-group row">
                                    <label for="{{ $attributes['id'] }}" class="col-sm-2 col-form-label">
                                        {{ $attributes['label'] }}
                                        @if(isset($attributes['required']) && $attributes['required'])
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <div class="{{ empty($attributes['col']) ? 'col-sm-10' : 'col-sm-' . $attributes['col'] }}">
                                        @if(isset($attributes['control']) && $attributes['control'] == 'radio')
                                            <!-- Radio Buttons -->
                                            @foreach($attributes['in'] as $key => $value)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error($field) is-invalid @enderror" 
                                                        type="radio" 
                                                        name="{{ $attributes['name'] }}" 
                                                        id="{{ $attributes['id'] }}_{{ $key }}" 
                                                        value="{{ $key }}" 
                                                        {{ (old($field, $attributes['value'] ?? null) == $key) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="{{ $attributes['id'] }}_{{ $key }}">
                                                        {{ $value }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @elseif(isset($attributes['control']) && ($attributes['control'] == 'date' || $attributes['control'] == 'datetime'))
                                            <!-- Date Input -->
                                            <input type="{{ $attributes['control'] == 'date' ? 'date' : 'datetime-local' }}" 
                                                class="form-control @error($field) is-invalid @enderror" 
                                                name="{{ $attributes['name'] }}" 
                                                id="{{ $attributes['id'] }}" 
                                                placeholder="{{ $attributes['placeholder'] }}" 
                                                value="{{ old($field, $attributes['value'] ?? '') }}" 
                                                {{ $attributes['required'] ? 'required' : '' }}>
                                        @elseif(isset($attributes['control']) && $attributes['control'] == 'textarea')
                                            <!-- Textarea -->
                                            <textarea 
                                                class="form-control @error($field) is-invalid @enderror" 
                                                name="{{ $attributes['name'] }}" 
                                                id="{{ $attributes['id'] }}" 
                                                placeholder="{{ $attributes['placeholder'] }}" 
                                                rows="4" 
                                                {{ $attributes['nullable'] ? '' : 'required' }}
                                                {{ isset($attributes['maxlength']) ? 'maxlength=' . $attributes['maxlength'] : '' }}>{{ old($field, $attributes['value'] ?? '') }}</textarea>
                                        @elseif(isset($attributes['control']) && $attributes['control'] == 'number')
                                            <!-- Number Input (for height, weight, etc.) -->
                                            <input type="number" 
                                                class="form-control @error($field) is-invalid @enderror" 
                                                name="{{ $attributes['name'] }}" 
                                                id="{{ $attributes['id'] }}" 
                                                placeholder="{{ $attributes['placeholder'] }}" 
                                                value="{{ old($field, $attributes['value'] ?? '') }}" 
                                                {{ isset($attributes['required']) && $attributes['required'] ? 'required' : '' }} 
                                                {{ isset($attributes['min']) ? 'min=' . $attributes['min'] : '' }}
                                                {{ isset($attributes['max']) ? 'max=' . $attributes['max'] : '' }}>
                                        @elseif(isset($attributes['control']) && $attributes['control'] == 'select-option')
                                            <!-- Dropdown Select -->
                                            <select class="form-control @error($field) is-invalid @enderror" 
                                                    name="{{ $attributes['name'] }}" 
                                                    id="{{ $attributes['id'] }}"
                                                    {{ isset($attributes['required']) && $attributes['required'] ? 'required' : '' }}>
                                                
                                                <option value="" disabled selected>Pilih {{ $attributes['placeholder'] ?? 'Pilihan' }}</option>
                                                
                                                @foreach($attributes['in'] as $key => $value)
                                                    <option value="{{ $key }}" 
                                                        {{ old($field, $attributes['value'] ?? null) == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif(isset($attributes['control']) && $attributes['control'] == 'select-search-ajax')
                                            <!-- Dropdown Select with AJAX Search -->
                                            <select class="form-control select-ajax @error($field) is-invalid @enderror" 
                                                    name="{{ $attributes['name'] }}" 
                                                    id="{{ $attributes['id'] }}" 
                                                    data-url="{{ url($attributes['url'] ?? '') }}" 
                                                    data-placeholder="{{ $attributes['placeholder'] ?? 'Pilih Pilihan' }}"
                                                    {{ isset($attributes['required']) && $attributes['required'] ? 'required' : '' }}>
                                                
                                                <option value="" disabled selected>{{ $attributes['placeholder'] ?? 'Pilih Pilihan' }}</option>
                                                @if(!empty($attributes['value']))
                                                    <!-- Add selected option dynamically -->
                                                    <option value="{{ $attributes['value'] }}" selected>{{ $attributes['selected_text'] ?? 'Pilihan Terpilih' }}</option>
                                                @endif
                                            
                                            </select>                                        
                                        @else
                                            <!-- Default Input -->
                                            <input type="{{ $attributes['type'] ?? 'text' }}" 
                                                class="form-control @error($field) is-invalid @enderror" 
                                                name="{{ $attributes['name'] }}" 
                                                id="{{ $attributes['id'] }}" 
                                                placeholder="{{ $attributes['placeholder'] }}" 
                                                value="{{ old($field, $attributes['value'] ?? '') }}" 
                                                {{ isset($attributes['required']) && $attributes['required'] ? 'required' : '' }} 
                                                {{ isset($attributes['maxlength']) ? 'maxlength=' . $attributes['maxlength'] : '' }}>
                                        @endif
                            
                                        @error($field)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route($resource.'.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<br><br>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select-ajax').each(function () {
                const select = $(this);
                const url = select.data('url');
                const placeholder = select.data('placeholder') || 'Pilih';

                // Initialize select2 with search functionality
                select.select2({
                    placeholder: placeholder,
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 300, 
                        data: function (params) {
                            return {
                                search: params.term, 
                                limit: 10,          
                            };
                        },
                        processResults: function (data) {
                            console.log(data);
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.text
                                }))
                            };
                        }
                    },
                    minimumInputLength: 4, // Trigger AJAX after 4 characters
                });
            });
        });
    </script>
@endpush
