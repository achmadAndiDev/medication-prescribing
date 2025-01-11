@php
    $formTitle = 'Detail';
    if (!empty($resource)) {
        $title = $title ?? Lang::get(Str::snake($resource) . '.title');
    }
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary">Detail {{ $title }}</h6>
            
                <a href="{{ route($resource.'.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped">
                <tbody>
                    @foreach ($data as $key => $value)
                        <tr>
                            <th class="text-capitalize text-secondary" style="width: 20%;">
                                {{-- <i class="fas fa-info-circle"></i>  --}}
                                {{ __($resource . '.' . $key) }}
                            </th>
                            <td>
                                @if ($key === 'gender')
                                    <span class="badge badge-pill badge-info">
                                        {{ $value === 'L' ? 'Laki-laki' : ($value === 'P' ? 'Perempuan' : '-') }}
                                    </span>
                                @elseif (Str::contains($key, 'date'))
                                    {{ $value ? \Carbon\Carbon::parse($value)->format('d-m-Y') : '-' }}
                                @else
                                    {{ $value ?? '-' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
</div>
@endsection
