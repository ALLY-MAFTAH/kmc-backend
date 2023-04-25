@extends('layouts.app')

@section('title')
    Register New Business Firms
@endsection
@section('style')
    <style>
        datalist {
            background-color: #f2f2f2;
            font-size: 14px;
        }
    </style>
@endsection
@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper px-2 py-2">
            <div class="card ">
                <div class=" card-header">
                    <div class="row">
                        <div class="col">
                            <div class=" text-left">
                                <h5 class="my-0">
                                    <span class="">
                                        <small>{{ __('Business Firm Registration Form') }}
                                        </small>

                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('businesses.add') }}" method="POST">
                        @csrf
                        <br>
                        <div class="" style="color:gray">Business Info</div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="name"
                                    class=" col-form-label text-sm-start">{{ __('Business Name') }}</label><span
                                    class="text-danger"> *</span>
                                <div class="">
                                    <input id="name" type="text" placeholder="Name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="tin" class=" col-form-label text-sm-start">{{ __('TIN') }}
                                    <span class="text-danger"> *</span> </label>
                                <div class="">
                                    <input id="tin" type="number" placeholder="TIN"
                                        class="form-control @error('tin') is-invalid @enderror" name="tin"
                                        value="{{ old('tin') }}"required autocomplete="tin" autofocus>
                                    @error('tin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="nida" class=" col-form-label text-sm-start">{{ __('NIDA Number') }}
                                    <span class="text-danger"> *</span> </label>
                                <div class="">
                                    <input id="nida" type="number" placeholder="NIDA"
                                        class="form-control @error('nida') is-invalid @enderror" name="nida"
                                        value="{{ old('nida') }}"required autocomplete="nida" autofocus>
                                    @error('nida')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="payerId"
                                    class=" col-form-label text-sm-start">{{ __("Payer's ID") }}</label><span
                                    class="text-danger"> *</span>
                                <div class="">
                                    <input id="payerId" type="number" placeholder="Payer's ID" required
                                        class="form-control @error('payerId') is-invalid @enderror" name="payerId"
                                        value="{{ old('payerId') }}" autocomplete="payerId" autofocus>
                                    @error('payerId')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="type_id" class=" col-form-label text-sm-start">{{ __('Business Type') }}
                                    <span class="text-danger"> *</span></label>
                                <select id="type_id" type="text"
                                    class="form-control form-select @error('type_id') is-invalid @enderror" name="type_id"
                                    value="{{ old('type_id') }}" required autocomplete="type_id" autofocus>
                                    <option value="">Choose Business Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col mb-2">
                                <label for="source_id" class=" col-form-label text-sm-start">{{ __('Revenue Source') }}
                                    <span class="text-danger"> *</span></label>
                                <select id="source_id" type="text"
                                    class="form-control form-select @error('source_id') is-invalid @enderror"
                                    name="source_id" value="{{ old('source_id') }}" required autocomplete="source_id"
                                    autofocus>
                                    <option value="1">Business Licence</option>
                                    {{-- @foreach ($sources as $source)
                                    <option value="{{ $source->id }}">
                                        {{ $source->name }}
                                    </option>
                                    @endforeach --}}
                                </select>
                                @error('source_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col mb-2">
                                <label for="mobile" class=" col-form-label text-sm-start">{{ __('Mobile') }}
                                    <span class="text-danger"> *</span> </label>
                                <div class="">
                                    <input id="mobile" type="tel" pattern="[+255]{4}[0-9]{9}"
                                        placeholder="+255712345678"
                                        class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                        value="{{ old('mobile') }}"required autocomplete="phone" autofocus>
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="email" class=" col-form-label text-sm-start">{{ __('Email') }}
                                    <span class="text-danger"> *</span> </label>
                                <div class="">
                                    <input id="email" type="email" placeholder="me@business.com"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}"required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="" style="color:gray">Location</div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="province_id" class=" col-form-label text-sm-start">{{ __('Province') }}
                                    <span class="text-danger"> *</span></label>
                                <select id="province_id" type="number"
                                    class="form-control form-select @error('province_id') is-invalid @enderror"
                                    name="province_id" value="{{ old('province_id') }}" required
                                    autocomplete="province_id" autofocus>
                                    <option value="">Choose Province</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col mb-2">
                                <label for="ward_id" class=" col-form-label text-sm-start">{{ __('Ward') }}
                                    <span class="text-danger"> *</span></label>
                                <select id="ward_id" type="number"
                                    class="form-control form-select @error('ward_id') is-invalid @enderror" name="ward_id"
                                    value="{{ old('ward_id') }}" required autocomplete="ward_id" autofocus>
                                    <option value="">Choose Ward</option>
                                    @foreach ($wards as $ward)
                                        <option value="{{ $ward->id }}">
                                            {{ $ward->name }}
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
                                <label for="sub_ward_id" class=" col-form-label text-sm-start">{{ __('Sub-Ward') }}
                                    <span class="text-danger"> *</span></label>
                                <select id="sub_ward_id" type="number"
                                    class="form-control form-select @error('sub_ward_id') is-invalid @enderror"
                                    name="sub_ward_id" value="{{ old('sub_ward_id') }}" required
                                    autocomplete="sub_ward_id" autofocus>
                                    <option value="">Choose Sub-Ward</option>
                                    @foreach ($subWards as $subWard)
                                        <option value="{{ $subWard->id }}">
                                            {{ $subWard->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sub_ward_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col mb-2">
                                <label for="street_name" class=" col-form-label text-sm-start">{{ __('Street') }}
                                    <span class="text-danger"> *</span></label>
                                <input id="street_name" type="text" placeholder=""
                                    class="form-control @error('street_name') is-invalid @enderror"
                                    name="street_name" value="" required list="streets">
                                <datalist id="streets">
                                    @foreach ($streets as $street)
                                        <option value="{{ $street->name }}">
                                        </option>
                                    @endforeach
                                </datalist>
                                @error('street_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="address" class=" col-form-label text-sm-start">{{ __('Address') }}
                                    <span class="text-danger"> *</span> </label>
                                <div class="">
                                    <input id="address" type="text" placeholder="P.O.Box"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address') }}"required autocomplete="address" autofocus>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="latitude" class=" col-form-label text-sm-start">{{ __('Latitude') }}
                                </label>
                                <div class="">
                                    <input id="latitude" type="text" placeholder=""
                                        class="form-control @error('latitude') is-invalid @enderror" name="latitude"
                                        value="{{ old('latitude') }}" autocomplete="latitude" autofocus>
                                    @error('latitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="longitude" class=" col-form-label text-sm-start">{{ __('Longitude') }}
                                </label>
                                <div class="">
                                    <input id="longitude" type="text" placeholder=""
                                        class="form-control @error('longitude') is-invalid @enderror" name="longitude"
                                        value="{{ old('longitude') }}" autocomplete="longitude" autofocus>
                                    @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="house_number" class=" col-form-label text-sm-start">{{ __('House Number') }}
                                </label>
                                <div class="">
                                    <input id="house_number" type="text" placeholder=""
                                        class="form-control @error('house_number') is-invalid @enderror"
                                        name="house_number" value="{{ old('house_number') }}"
                                        autocomplete="house_number" autofocus>
                                    @error('house_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="" style="color:gray">Licence</div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="number" class=" col-form-label text-sm-start">{{ __('Licence Number') }}
                                    <span class="text-danger"> *</span> </label>
                                <div class="">
                                    <input id="number" type="text" placeholder=""
                                        class="form-control @error('number') is-invalid @enderror" name="number"
                                        value="{{ old('number') }}"required autocomplete="number" autofocus>
                                    @error('number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-1">
                                <label for="start_date"
                                    class=" col-form-label text-sm-start">{{ __('Start Date') }}</label><span
                                    class="text-danger"> *</span>
                                <div class="">
                                    <input id="start_date" type="date" placeholder=""
                                        class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                        value="{{ old('start_date') }}" autocomplete="start_date" autofocus>
                                    @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-1">
                                <label for="end_date"
                                    class=" col-form-label text-sm-start">{{ __('End Date') }}</label><span
                                    class="text-danger"> *</span>
                                <div class="">
                                    <input id="end_date" type="date" placeholder=""
                                        class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                        value="{{ old('end_date') }}" autocomplete="end_date" autofocus>
                                    @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="receipt_number"
                                    class=" col-form-label text-sm-start">{{ __('Receipt Number') }}</label><span
                                    class="text-danger"> *</span>
                                <div class="">
                                    <input id="receipt_number" type="text" placeholder="" required
                                        class="form-control @error('receipt_number') is-invalid @enderror"
                                        name="receipt_number" value="{{ old('receipt_number') }}"
                                        autocomplete="receipt_number" autofocus>
                                    @error('receipt_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-2 mt-2">
                            <div class="text-center">
                                <button type="submit" class="btn  btn-outline-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>

    </div>
@endsection
@section('scripts')

    <script>
        $(document).ready(function() {
            $("#start_date").change(function() {
                var start_date = new Date($(this).val());
                var end_date = new Date(start_date);
                end_date.setFullYear(end_date.getFullYear() + 1);
                end_date.setDate(end_date.getDate() - 1);
                $("#end_date").val(end_date.toISOString().substring(0, 10));
            });
        });
    </script>
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
                        $("#streets").html(""); // clear the options
                        $("#streets").html(data.filteredStreets);
                    }
                });
            });
        });
    </script>
@endsection
