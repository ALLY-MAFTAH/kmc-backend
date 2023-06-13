@extends('layouts.app')

@section('title')
    Vehicle
@endsection

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper px-2">
            <div class="card">
                <div class=" card-header">
                    <div class="row">
                        <div class="col">
                            <div class=" text-left">
                                <h5 class="my-0">
                                    <span class="">
                                        <small>{{ __('Vehicle Under Kinondoni Municipal') . ' - ' }}
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $vehicles->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <form action="{{ route('vehicles.index') }}" method="GET" id="filter-form">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <select name="sticker_status" id="sticker_status"
                                                class="form-select  mx-1 form-control" style="border-radius:0.375rem;"
                                                onchange="this.form.submit()">
                                                <option
                                                    value='All Vehiclees'{{ $sticker_status == 'All Vehiclees' ? 'selected' : '' }}>
                                                    All Vehicles </option>
                                                <option value='1'{{ $sticker_status == '1' ? 'selected' : '' }}>
                                                    With Valid Stickers </option>
                                                <option value='0'{{ $sticker_status == '0' ? 'selected' : '' }}>
                                                    With Expired Stickers </option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <select name="type_id" id="type_id" class="form-select  mx-1 form-control"
                                                style="border-radius:0.375rem;" onchange="this.form.submit()">
                                                {{-- <option value='All Types'{{ $type_id == 'All Types' ? 'selected' : '' }}>
                                                    All Types </option>

                                                    <option
                                                        value='{{ "Pikipiki" }}'{{ $type->id == $type_id ? 'selected' : '' }}>
                                                        {{ $type->name }} </option> --}}

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col text-right">
                            <a href="#" class="btn  btn-outline-primary collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#registerVehicle" aria-expanded="false"
                                aria-controls="registerVehicle">

                                <i class="feather icon-plus"></i> Register New Vehicle

                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="registerVehicle" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                        aria-labelledby="registerVehicle" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                                <form action="{{ route('vehicles.add') }}" method="POST">
                                    @csrf
                                    <br>
                                    <div class="" style="color:gray">Vehicle Info</div>
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="reg_number"
                                                class=" col-form-label text-sm-start">{{ __('Registration Number') }}</label><span
                                                class="text-danger"> *</span>
                                            <div class="">
                                                <input id="reg_number" type="text" placeholder="T123 ABC"
                                                    class="form-control @error('reg_number') is-invalid @enderror"
                                                    name="reg_number" value="{{ old('reg_number') }}" required
                                                    autocomplete="reg_number" autofocus>
                                                @error('reg_number')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <label for="brand" class=" col-form-label text-sm-start">{{ __('Brand') }}
                                                <span class="text-danger"> *</span> </label>
                                            <div class="">
                                                <input id="brand" type="brand" placeholder="Brand"
                                                    class="form-control @error('brand') is-invalid @enderror" name="brand"
                                                    value="{{ old('brand') }}"required autocomplete="brand" autofocus>
                                                @error('brand')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <label for="color" class=" col-form-label text-sm-start">{{ __('Color') }}
                                                <span class="text-danger"> *</span> </label>
                                            <div class="">
                                                <input id="color" type="text" placeholder="Color"
                                                    class="form-control @error('color') is-invalid @enderror" name="color"
                                                    value="{{ old('color') }}"required autocomplete="color" autofocus>
                                                @error('color')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-2">
                                            <label for="type"
                                                class=" col-form-label text-sm-start">{{ __('Vehicle Type') }}
                                                <span class="text-danger"> *</span></label>
                                            <select id="type" type="text"
                                                class="form-control form-select @error('type') is-invalid @enderror"
                                                name="type" value="{{ old('type') }}" required autocomplete="type"
                                                autofocus>
                                                <option value="">--Choose Vehicle Type--</option>
                                                <option value="Bajaji">Bajaji</option>
                                                <option value="Pikipiki">Pikipiki</option>
                                            </select>
                                            @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="parking_id"
                                                class=" col-form-label text-sm-start">{{ __('Parking') }}
                                                <span class="text-danger"> *</span></label>
                                            <select id="parking_id" type="text"
                                                class="form-control form-select @error('parking_id') is-invalid @enderror"
                                                name="parking_id" value="{{ old('parking_id') }}" required
                                                autocomplete="parking_id" autofocus>
                                                <option value="">--Choose Parking--</option>
                                                @foreach ($parkings as $parking)
                                                    <option value="{{ $parking->id }}">{{ $parking->pln }}
                                                        ({{ $parking->name }})
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('parking_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <label for="driver_id"
                                                class=" col-form-label text-sm-start">{{ __('Driver') }}
                                                <span class="text-danger"> </span></label>
                                            <select id="driver_id" type="text"
                                                class="form-control form-select @error('driver_id') is-invalid @enderror"
                                                name="driver_id" value="{{ old('driver_id') }}" autocomplete="driver_id"
                                                autofocus>
                                                <option value="">--Choose Driver--</option>
                                                @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->id }}">{{ $driver->first_name }}
                                                        {{ $driver->middle_name }} {{ $driver->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('driver_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col mb-2">
                                            <label for="owner_id"
                                                class=" col-form-label text-sm-start">{{ __('Owner') }}
                                                <span class="text-danger"> </span></label>
                                            <select id="owner_id" type="text"
                                                class="form-control form-select @error('owner_id') is-invalid @enderror"
                                                name="owner_id" value="{{ old('owner_id') }}" autocomplete="owner_id"
                                                autofocus>
                                                <option value="">--Choose Owner--</option>
                                                @foreach ($owners as $owner)
                                                    <option value="{{ $owner->id }}">{{ $owner->first_name }}
                                                        {{ $owner->middle_name }} {{ $owner->last_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('owner_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="" style="color:gray">Sticker Details</div>
                                    <div class="row">
                                        <div class="col mb-2">
                                            <label for="number"
                                                class=" col-form-label text-sm-start">{{ __('Sticker Number') }}
                                                <span class="text-danger"> *</span> </label>
                                            <div class="">
                                                <input id="number" type="text" placeholder=""
                                                    class="form-control @error('number') is-invalid @enderror"
                                                    name="number" value="{{ old('number') }}"required
                                                    autocomplete="number" autofocus>
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
                                                    class="form-control @error('start_date') is-invalid @enderror"
                                                    name="start_date" value="{{ old('start_date') }}"
                                                    autocomplete="start_date" autofocus>
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
                                                    class="form-control @error('end_date') is-invalid @enderror"
                                                    name="end_date" value="{{ old('end_date') }}"
                                                    autocomplete="end_date" autofocus>
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
                    </div>
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3  table table-hover"style="width: 100%">
                            <thead class="table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Reg. Number</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Color</th>
                                    <th>Current Sticker No.</th>
                                    <th>PLN</th>
                                    <th>Driver</th>
                                    <th>Owner</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredVehicles as $index => $vehicle)
                                <tr ondblclick="goToVehicleTr(event)" data-id="{{ $vehicle->reg_number }}"
                                    style="cursor: pointer">                                        <td>{{ ++$index }}</td>
                                        <td>{{ Illuminate\Support\Str::upper($vehicle->reg_number) }}</td>
                                        <td>{{ $vehicle->type }}</td>
                                        <td>{{ $vehicle->brand }}</td>
                                        <td>{{ $vehicle->color }}</td>
                                        @if ($vehicle->stickers->last()->is_valid)
                                            <td>{{ $vehicle->stickers->last()->number }}</td>
                                        @else
                                            <td class="text-danger">{{ $vehicle->stickers->last()->number }}</td>
                                        @endif
                                        <td>{{ $vehicle->parking->pln }}</td>
                                        @if ($vehicle->driver)
                                            <td>{{ $vehicle->driver->first_name }} {{ $vehicle->driver->middle_name }}
                                                {{ $vehicle->driver->last_name }}</td>
                                        @else
                                            <td class="text-danger">
                                                Not Assigned
                                            </td>
                                        @endif
                                        @if ($vehicle->owner)
                                            <td>{{ $vehicle->owner->first_name }} {{ $vehicle->owner->middle_name }}
                                                {{ $vehicle->owner->last_name }}</td>
                                        @else
                                            <td class="text-danger">
                                                Not Assigned
                                            </td>
                                        @endif

                                        </td>
                                        <td class=" text-center">
                                            <a href="#" onclick="goToVehicleBtn(event)"
                                                data-id="{{ $vehicle->reg_number }}" class="btn btn-outline-info mx-2">View</a>
                                            <a href="#" class="btn  btn-outline-danger mx-2"
                                                onclick="if(confirm('Are you sure want to delete {{ $vehicle->name }}?')) document.getElementById('delete-vehicle-{{ $vehicle->id }}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-vehicle-{{ $vehicle->id }}" method="post"
                                                action="{{ route('vehicles.delete', $vehicle) }}">@csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
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
        function goToVehicleTr(event) {
            var reg_number = event.target.parentNode.dataset.id;
            window.location.href = '/vehicle?reg_number=' + reg_number;
        }

        function goToVehicleBtn(event) {
            var reg_number = event.target.dataset.id;
            window.location.href = '/vehicle?reg_number=' + reg_number;
        }
    </script>
@endsection
