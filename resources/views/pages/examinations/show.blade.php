@php
    $formTitle = 'Detail';
    if (!empty($resource)) {
        $title = $title ?? Lang::get(Str::snake($resource) . '.title');
    }
    $colTwo = true;
@endphp

@extends('layouts.main')

@section('title', $formTitle . ' ' . $title)

@section('content')
<div class="container-fluid">
    <!-- Header -->
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

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><i class="fas fa-pills"></i> Daftar Obat Pasien</h5>
            <!-- Button to trigger modal -->
            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#addMedicineModal">
                <i class="fas fa-plus"></i> Tambah Obat
            </button>

            <!-- Modal -->
            <div class="modal fade" id="addMedicineModal" tabindex="-1" aria-labelledby="addMedicineModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl-custom">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMedicineModalLabel">Pilih Obat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 medicineList-tab" >
                                    <div id="medicineListSection">
                                        <div class="form-group">
                                            <label for="searchMedicine">Cari Obat</label>
                                            <input type="text" id="searchMedicine" class="form-control" placeholder="Cari Obat...">
                                        </div>
                                
                                        <div class="list-group" id="medicineList">
                                            {{-- daftar obat  --}}
                                        </div>
                                    </div>
                            
                                    <div id="medicineDetails" class="mt-4 d-none">
                                        <button id="backButton" class="btn btn-sm btn-secondary mb-3">Kembali</button>
                                        <h5>Harga Obat</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Selesai</th>
                                                        <th>Harga Satuan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="priceList">
                                                    {{-- Detail harga obat --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Daftar Obat</h6>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="selectedMedicines">
                                            {{-- Tabel obat terpilih --}}
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            @if (count($prescriptions))
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Dosis</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prescriptions as $index => $prescription)
                                @foreach ($prescription->details as $detail)
                                    <tr>
                                        <td>{{ $loop->parent->iteration }}</td>
                                        <td>{{ $detail->medicine_name }}</td>
                                        <td>{{ $detail->dosage }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ $detail->description ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <center>
                    <p class="text-muted">Belum ada data obat.</p>
                </center>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
        // Fetch medicines list
        function fetchMedicines(query = '') {
            $.ajax({
                url: '{{ route('medicines.fetch') }}',  // Use your Laravel route here
                method: 'GET',
                data: { query: query },
                success: function (response) {
                    const medicines = response.medicines;
                    $('#medicineList').empty();
                    medicines.forEach(medicine => {
                        if (medicine.name.toLowerCase().includes(query.toLowerCase())) {
                            $('#medicineList').append(`
                                <button class="list-group-item list-group-item-action medicine-item" data-id="${medicine.id}">
                                    ${medicine.name}
                                </button>
                            `);
                        }
                    });
                },
                error: function (error) {
                    alert('Unable to fetch medicines');
                }
            });
        }

        // Fetch medicine prices
        function fetchMedicinePrices(medicineId) {
            $.ajax({
                url: '{{ route('medicines.prices', ['id' => ':medicineId']) }}'.replace(':medicineId', medicineId),
                method: 'GET',
                success: function (response) {
                    const prices = response.prices;
                    $('#priceList').empty();
                    prices.forEach(price => {
                        $('#priceList').append(`
                            <tr>
                                <td>${price.start_date.formatted}</td>
                                <td>${price.end_date.formatted}</td>
                                <td>${price['unit_price']}</td>
                                <td><button class="btn btn-sm btn-primary addToSelected">Add</button></td>
                            </tr>
                        `);
                    });
                    $('#medicineDetails').removeClass('d-none');
                    $('#medicineListSection').addClass('d-none');
                },
                error: function (error) {
                    alert('Unable to fetch medicine prices');
                }
            });
        }

        // Search functionality
        $('#searchMedicine').on('keyup', function () {
            const query = $(this).val();
            fetchMedicines(query);
        });

        // Show medicine prices when clicking on a medicine item
        $('#medicineList').on('click', '.medicine-item', function () {
            const medicineId = $(this).data('id');
            fetchMedicinePrices(medicineId);
        });

        $('#priceList').on('click', '.addToSelected', function () {
            const row = $(this).closest('tr');
            const price = row.find('td').eq(2).text();
            const medicineName = $('.medicine-item[data-id="' + row.closest('tr').data('id') + '"]').text();

            // Add selected medicine to table
            $('#selectedMedicines').append(`
                <tr>
                    <td>${medicineName}</td>
                    <td>${price}</td>
                    <td><input type="number" class="form-control" value="1" min="1"></td>
                    <td><button class="btn btn-sm btn-danger removeMedicine">Remove</button></td>
                </tr>
            `);


            $('#medicineDetails').addClass('d-none');
            $('#medicineListSection').removeClass('d-none');
        });

         // Remove medicine from selected list
        $('#selectedMedicines').on('click', '.removeMedicine', function () {
            $(this).closest('tr').remove();
        });

        // Back button functionality
        $('#backButton').on('click', function () {
            $('#medicineDetails').addClass('d-none');
            $('#medicineListSection').removeClass('d-none');
        });

        // Initial fetch
        fetchMedicines();
    });

    </script>
@endpush
