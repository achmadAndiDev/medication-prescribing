
@php
if (!empty($resource)) {
    if (empty($title)) {
        $title = Lang::get(Str::snake($resource) . '.title');
    }
    if (empty($subtitle)) {
        $subtitle = 'Daftar' . ' ' . $title;
    }
}
@endphp

@extends('layouts.main')

@section('title', $title)

@push('stylesheets')
    <link href="{{ asset('public/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .pagination-sm {
            font-size: 12px; /* Adjust size as needed */
        }

        .pagination-sm ul.pagination {
            margin-left:10px;
        }

        .pagination-sm .text-muted {
            font-size: 100%;
        }

        .me-2 {
            margin-right: 2px;
        }

        .me-4 {
            margin-right: 4px;
        }

        .actions-d-flex {
            border: none !important;
            border-top: 1px solid #e3e6f0 !important;
        }
    </style>
@endpush

@section('content')

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1> <!-- Updated heading -->

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li> <!-- Updated breadcrumb item -->
            </ol>
        </nav>
    </div>

    <div class="card shadow">
        <div class="card-header d-sm-flex align-items-center justify-content-between ">
            <h6 class="m-0 font-weight-bold text-primary">Data {{ $title }}</h6> <!-- Updated card header -->
            <div class="d-sm-flex justify-content-end ">
                <a href="{{ url($resource).'/create' }}" class="btn btn-success btn-sm pull-right" style="margin-left:10px"><i class="fa fa-plus"></i> Tambah Data</a>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center">
                    <div class="me-4">
                        <select name="field" id="field" class="form-control form-control-sm d-inline-block w-auto">
                            <option value="all">Semua</option>
                            @foreach($filterableHeaders as $headItem)
                                <option value="{{ $headItem['field'] }}" {{ request('field') == $headItem['field'] ? 'selected' : '' }}>
                                    {{ $headItem['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="me-4">
                        <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="masukan pencarian..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary me-4">
                        <i class="fa fa-search"></i>
                    </button>
                    <a href="{{ url()->current() }}" class="btn btn-sm btn-secondary ms-2">
                        <i class="fa fa-sync-alt"></i> 
                    </a>
                </form>
            </div>
    
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            @foreach($header as $headItem)
                                <th>{{ $headItem['label'] }}</th>
                            @endforeach
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                                </td>
                                @foreach($header as $headItem)
                                    <td>{{ $item[$headItem['field']] }}</td>
                                @endforeach
                                <td class="d-flex justify-content-between actions-d-flex">
                                    <a href="{{ route($resource.'.show', $item->id) }}" class="btn btn-xs btn-primary me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route($resource.'.edit', $item->id) }}" class="btn btn-xs btn-info me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-xs btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="confirmDelete('{{ $item->id }}', '{{ $item->name }}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>                          
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between mb-3">
                    <form method="GET" action="{{ url()->current() }}">
                        <label for="limit" class="me-2">Show:</label>
                        <select name="limit" id="limit" class="form-control form-control-sm d-inline-block w-auto" onchange="this.form.submit()">
                            @foreach([10, 20, 50] as $option)
                                <option value="{{ $option }}" {{ request('limit', 10) == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <div class="pagination-sm">
                        {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin menghapus data <b>"<span id="patientName"></span>"</b>? Data yang terhapus tidak bisa dikembalikan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('public/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        function confirmDelete(id, patientName) {
            document.getElementById('patientName').innerText = patientName;

            let formAction = '/patients/' + id; 
            document.getElementById('deleteForm').action = formAction;

            let modalDelete = new bootstrap.Modal(document.getElementById('deleteModal'));
            modalDelete.show();
        }

        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        @if(session('success'))
            Swal.fire({
                title: 'Executed!',
                text: "{{ session('success') }}",
                icon: 'success',
                position: 'top-end', // Set the position to top-start
                showConfirmButton: false,
                timer: 2000 // Auto close after 2 seconds
            });
        @endif
    </script>
@endpush
