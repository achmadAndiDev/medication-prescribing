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
        <div class="card-header d-flex justify-content-between">
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
                                        <div class="d-flex justify-content-between mb-3">
                                            <!-- Nama Obat Terpilih -->
                                            <input type="hidden" name="medicine_id" id="selectedMedicineId">
                                            <input type="hidden" name="medicine_name" id="selectedMedicineName">
                                            <span id="selectedMedicineNameInfo" class="me-3 fw-bold"></span>
                                    
                                            <!-- Tombol Kembali dengan Ikon -->
                                            <button id="backButton" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </button>
                                        </div>
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
                                <div class="col-md-6 medicineList-tab">
                                    <div class="d-flex justify-content-between">
                                        <h6>Daftar Obat</h6>
                                        <button class="btn btn-primary" id="saveSelectedMedicines">Simpan</button>
                                    </div>  
                                    <br>
                                    <input type="hidden" id="examinationId" name="examination_id" value="{{ $id }}">
                                    <textarea id="medicineNote" name="medicine_note" class="form-control" rows="2" placeholder="Tambah catatan resep (Optional)"></textarea>
                                    <br>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th>Harga Satuan</th>
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
                            @php
                                dd($prescriptions);
                            @endphp
                            @foreach ($prescriptions as $prescription)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $prescription->medicine_name }}</td>
                                    <td>{{ $prescription->dosage }}</td>
                                    <td>{{ $prescription->quantity }}</td>
                                    <td>{{ $prescription->description ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-xs btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('prescriptions.destroy', $prescription->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
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
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', 
                currency: 'IDR' 
            }).format(amount);
        }

        let selectedMedicines = [];

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
                                <td>${formatRupiah(price['unit_price'])}</td>
                                <td>
                                    <button 
                                        class="btn btn-xs btn-primary addToSelected" 
                                        data-start-date="${price.start_date.value}" data-end-date="${price.end_date.value}" data-unit-price="${price['unit_price']}"
                                    >
                                        Pilih
                                    </button>
                                </td>
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
            const medicineName = $(this).text();

            $('#selectedMedicineNameInfo').text(medicineName);
            $('#selectedMedicineId').val(medicineId);
            $('#selectedMedicineName').val(medicineName);

            fetchMedicinePrices(medicineId);
        });

        $('#priceList').on('click', '.addToSelected', function () {
            const button = $(this);
            const medicine = {
                id: $('#selectedMedicineId').val(),
                name: $('#selectedMedicineName').val(),
                start_date: button.data('start-date'),
                end_date: button.data('end-date'),    
                unit_price: button.data('unit-price'),
                quantity: 1,
            };

            selectedMedicines.push(medicine);
            renderSelectedMedicines();
        });

        function renderSelectedMedicines() {
            const tableBody = $('#selectedMedicines');
            tableBody.empty();

            selectedMedicines.forEach((medicine, index) => {
                tableBody.append(`
                    <tr data-index="${index}">
                        <td>${medicine.name}</td>
                        <td>${formatRupiah(medicine.unitPrice)}</td>
                        <td><input type="number" class="form-control quantity-input" value="${medicine.quantity}" min="1" data-index="${index}"></td>
                        <td><button class="btn btn-sm btn-danger removeMedicine" data-index="${index}">Hapus</button></td>
                    </tr>
                `);
            });

            $('#hiddenInputsContainer').empty();
            selectedMedicines.forEach((medicine) => {
                $('#hiddenInputsContainer').append(`
                    <input type="hidden" name="medicine_ids[]" value="${medicine.id}">
                    <input type="hidden" name="medicine_names[]" value="${medicine.name}">
                    <input type="hidden" name="unit_prices[]" value="${medicine.unitPrice}">
                    <input type="hidden" name="price_start_dates[]" value="${medicine.startDate}">
                    <input type="hidden" name="price_end_dates[]" value="${medicine.endDate}">
                    <input type="hidden" name="quantities[]" value="${medicine.quantity}">
                `);
            });
        }

         // Remove medicine from selected list
        $('#selectedMedicines').on('click', '.removeMedicine', function () {
            const index = $(this).data('index');
            selectedMedicines.splice(index, 1);
            renderSelectedMedicines();
        });

        // Back button functionality
        $('#backButton').on('click', function () {
            $('#medicineDetails').addClass('d-none');
            $('#medicineListSection').removeClass('d-none');
        });


        $('#saveSelectedMedicines').on('click', function () {
            // Ambil nilai dari catatan (note)
            const examinationId = $("#examinationId").val();
            const note = $("#medicineNote").val();

            if (selectedMedicines.length === 0) {
                alert("Pilih setidaknya satu obat sebelum menyimpan.");
                return;
            }

            // Log untuk memastikan data yang dikirim benar
            console.log("Selected Medicines:", selectedMedicines);
            console.log("Note:", note);

            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: '/prescriptions', // Ganti dengan endpoint yang sesuai di server Anda
                method: 'POST',
                contentType: 'application/json', // Pastikan content-type adalah JSON
                data: JSON.stringify({
                    examination_id: examinationId, // Data obat yang dipilih
                    medicines: selectedMedicines, // Data obat yang dipilih
                    note: note // Catatan tambahan
                }),
                success: function (response) {
                    // Tampilkan notifikasi keberhasilan
                    alert('Data berhasil disimpan!');
                    console.log("Response from server:", response);

                    // Reset selectedMedicines dan note
                    selectedMedicines = [];
                    $("#medicineNote").val('');
                    renderSelectedMedicines(); // Update tampilan, jika ada
                },
                error: function (error) {
                    // Tampilkan notifikasi error
                    alert('Terjadi kesalahan saat menyimpan data.');
                    console.error("Error:", error);
                }
            });
        });


        // Initial fetch
        fetchMedicines();
    });

    

    </script>
@endpush
