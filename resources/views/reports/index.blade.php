@extends('layouts.app')

@section('title')
    Reports
@endsection

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper px-2">
            <div class="card">
                <div class=" card-header">
                    <h5 class="my-0">
                        REPORTS </h5>
                </div>
                <div class="card-body">
                    <br>
                    <br>
                    <div class="row">
                        <div class="col text-center">
                            <a href="#" class="btn btn-outline-primary collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#vehicleReportForm" aria-expanded="false"
                                aria-controls="reportForm">Vehicle
                                Report</a>
                        </div>
                        <div class="col text-center">
                            <a href="#" class="btn btn-outline-primary collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#revenueReportForm" aria-expanded="false"
                                aria-controls="reportForm">Revenue
                                Report</a>
                        </div>
                        <div class="col text-center">
                            <a href="#" class="btn btn-outline-primary collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#licenceReportForm" aria-expanded="false"
                                aria-controls="reportForm">Licence
                                Report</a>
                        </div>
                       
                    </div>
                    <br>

                    <div id="vehicleReportForm" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                        aria-labelledby="vehicleReportForm" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                                <form method="GET" action="{{ route('reports.vehicle') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-1">
                                            <label for="from_date"
                                                class=" col-form-label text-sm-start">{{ __('Registered From') }}</label>
                                            <span class="text-danger"> *</span>
                                            <div class="">
                                                <input id="from_date" type="date"
                                                    class="form-control @error('from_date') is-invalid @enderror"
                                                    name="from_date" value="{{ old('from_date') }}"required
                                                    autocomplete="from_date" autofocus>
                                                @error('from_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-1">
                                            <label for="to_date"
                                                class=" col-form-label text-sm-start">{{ __('To') }}</label> <span
                                                class="text-danger"> *</span>
                                            <div class="">
                                                <input id="to_date" type="date"
                                                    class="form-control @error('to_date') is-invalid @enderror"
                                                    name="to_date" value="{{ old('to_date') }}"required
                                                    autocomplete="to_date" autofocus>
                                                @error('to_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col mb-2">
                                            <label for="ward_id" class=" col-form-label text-sm-start">{{ __('Ward') }}
                                            </label>
                                            <select id="ward_id" type="number"
                                                class="form-control form-select @error('ward_id') is-invalid @enderror"
                                                name="ward_id" value="{{ old('ward_id') }}" autocomplete="ward_id"
                                                autofocus>
                                                <option value="">All</option>
                                                @foreach ($wards as $ward)
                                                    <option value="{{ $ward }}">
                                                        {{ $ward }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('ward_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <label for="sub_ward_id"
                                                class=" col-form-label text-sm-start">{{ __('Sub-Ward') }}
                                            </label>
                                            <select id="sub_ward_id" type="number"
                                                class="form-control form-select @error('sub_ward_id') is-invalid @enderror"
                                                name="sub_ward_id" value="{{ old('sub_ward_id') }}"
                                                autocomplete="sub_ward_id" autofocus>
                                                <option value="">All</option>
                                                @foreach ($subWards as $subWard)
                                                    <option value="{{ $subWard }}">
                                                        {{ $subWard }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('sub_ward_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col mb-1">
                                            <label for="orientation"
                                                class=" col-form-label text-sm-start">{{ __('Orientation') }}</label>
                                            <span class="text-danger"> *</span>
                                            <div class="input-group">
                                                <select id="orientation" class="form-control form-select"
                                                    name="orientation" required>
                                                    <option value="">--</option>
                                                    <option value="potrait">Potrait</option>
                                                    <option value="landscape">Landscape</option>
                                                </select>
                                                @error('orientation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-1">
                                            <label for="group_by"
                                                class=" col-form-label text-sm-start">{{ __('Group By') }}</label>
                                            <div class="input-group">
                                                <select id="group_by" class="form-control form-select" name="group_by">
                                                    <option value="">None</option>
                                                    <option value="type_id">Type</option>
                                                    <option value="province_id">Province</option>
                                                    <option value="ward_id">Ward</option>
                                                    <option value="sub_ward_id">Sub-Ward</option>
                                                    <option value="street_id">Street</option>
                                                </select>
                                                @error('group_by')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-1">
                                            <label for="sort_by"
                                                class=" col-form-label text-sm-start">{{ __('Sort By') }}</label> <span
                                                class="text-danger"> *</span>
                                            <div class="input-group">
                                                <select id="sort_by" class="form-control form-select" name="sort_by"
                                                    required>
                                                    <option value="">--</option>
                                                    <option value="name">Vehicle Name</option>
                                                    <option value="tin">Vehicle TIN</option>
                                                    <option value="payersId">Payer's ID</option>
                                                    <option value="nida">NIDA</option>
                                                    <option value="created_at">Registered Date</option>
                                                    <option value="type_id">Type</option>
                                                </select>
                                                @error('sort_by')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 my-4">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Generate Report') }}
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#province_id").change(function(e) {
                e.preventDefault();
                var provinceId = $(this).val();
                $.ajax({
                    url: '/get-wards',
                    type: 'GET',
                    data: {
                        provinceId: provinceId
                    },
                    success: function(data) {
                        console.log(data.filteredWards);
                        $("#ward_id").html(""); // clear the options
                        $("#ward_id").html(data.filteredWards);
                    }
                });
            });
        });
        $(document).ready(function() {
            $("#ward_id").change(function(e) {
                e.preventDefault();
                var wardId = $(this).val();
                $.ajax({
                    url: '/get-sub-wards',
                    type: 'GET',
                    data: {
                        wardId: wardId
                    },
                    success: function(data) {
                        console.log(data.filteredSubWards);
                        $("#sub_ward_id").html(""); // clear the options
                        $("#sub_ward_id").html(data.filteredSubWards);
                    }
                });
            });
        });
        $(document).ready(function() {
            $("#sub_ward_id").change(function(e) {
                e.preventDefault();
                var subWardId = $(this).val();
                $.ajax({
                    url: '/get-streets',
                    type: 'GET',
                    data: {
                        subWardId: subWardId
                    },
                    success: function(data) {
                        console.log(data.filteredStreets);
                        $("#street_id").html(""); // clear the options
                        $("#street_id").html(data.filteredStreets);
                    }
                });
            });
        });
    </script>
@endsection
