@php
    $formTitle = 'Detail';
    if (!empty($resource)) {
        $title = $title ?? Lang::get(Str::snake($resource) . '.title');
    }
    // print_r($data); die;
    $colTwo = true;
@endphp

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
        @if ($colTwo)
            <div class="row">
                @php
                    $splitData = collect($data)->chunk(ceil(count($data) / 2));
                @endphp
                @foreach ($splitData as $chunk)
                    <div class="col-md-6">
                        <div class="d-flex flex-column gap-2" style="padding:0px 5px;">
                            @foreach ($chunk as $key => $value)
                                <div class="row p-2 border rounded mb-1" style="font-size: 0.85rem; " >
                                    <div class="col-md-4 text-capitalize text-secondary fw-bold">
                                        {{ __($resource . '.' . $key) }}
                                    </div>
                                    <div class="col-md-8">
                                        @if ($key === 'gender')
                                            <span class="badge bg-info text-light">
                                                {{ $value === 'L' ? 'Laki-laki' : ($value === 'P' ? 'Perempuan' : '-') }}
                                            </span>
                                        @elseif (Str::contains($key, 'date'))
                                            {{ $value ? \Carbon\Carbon::parse($value)->format('d-m-Y') : '-' }}
                                        @else
                                            {{ $value ?? '-' }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="d-flex flex-column gap-2">
                @foreach ($data as $key => $value)
                    <div class="row p-2 border rounded" style="font-size: 0.85rem;">
                        <div class="col-md-4 text-capitalize text-secondary fw-bold">
                            {{ __($resource . '.' . $key) }}
                        </div>
                        <div class="col-md-8">
                            @if ($key === 'gender')
                                <span class="badge bg-info text-light">
                                    {{ $value === 'L' ? 'Laki-laki' : ($value === 'P' ? 'Perempuan' : '-') }}
                                </span>
                            @elseif (Str::contains($key, 'date'))
                                {{ $value ? \Carbon\Carbon::parse($value)->format('d-m-Y') : '-' }}
                            @else
                                {{ $value ?? '-' }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>        
</div>