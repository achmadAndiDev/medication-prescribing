@php
    $formTitle = 'Detail';
    if (!empty($resource)) {
        $title = $title ?? Lang::get(Str::snake($resource) . '.title');
    }
    // print_r($data); die;
    $colTwo = true;
@endphp

@extends('layouts.main')

@section('title', $formTitle . ' ' . $title)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $formTitle }} {{ $title }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route($resource.'.index') }}">{{ $title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $formTitle }}</li>
            </ol>
        </nav>
    </div>

    <x-card-detail :resource="$resource" :data="$data" />
    
</div>
@endsection
