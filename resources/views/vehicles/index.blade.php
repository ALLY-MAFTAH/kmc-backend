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
                            <a href="{{ route('vehicles.show_add_form') }}"
                                class="btn  btn-outline-primary collapsed" type="button">
                                <i class="feather icon-plus"></i> Register New Vehicle Firm
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3  table table-hover"style="width: 100%">

                            <thead class="table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>TIN</th>
                                    <th>Payer's ID</th>
                                    <th>Current Sticker No.</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Type</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredVehicles as $index => $business)
                                    <tr ondblclick="goToVehicleTr(event)" data-id="{{ $business->tin }}"
                                        style="cursor: pointer">
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>
                                            <span id="tin_input_{{ $business->tin }}" style="display:none">
                                                <form action="{{ route('vehicles.change_tin', $business) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="tin" id=""
                                                        value="{{ old('tin', $business->tin) }}"required autofocus
                                                        style="border:none; width:auto">
                                                </form>
                                            </span>
                                            <span id="tin_value_{{ $business->tin }}" style="display:block">
                                                {{ substr($business->tin, 0, 3) . '-' . substr($business->tin, 0, 3) . '-' . substr($business->tin, -3) }}
                                                <a href="#"><i class="material-icons"style="font-size:13px">edit</i>
                                                </a>
                                            </span>
                                        </td>
                                        <td>{{ $business->payerId }}</td>
                                        @if ($business->stickers->last()->is_valid)
                                            <td>{{ $business->stickers->last()->number }}</td>
                                        @else
                                            <td class="text-danger">{{ $business->stickers->last()->number }}</td>
                                        @endif
                                        <td>{{ Illuminate\Support\Str::upper($business->name) }}</td>
                                        <td>{{ $business->mobile }}</td>
                                        <td>{{ $business->type }}</td>

                                        </td>
                                        <td class=" text-center">
                                            <form id="toggle-status-form-{{ $business->id }}" method="POST" class="px-3"
                                                action="{{ route('vehicles.toggle-status', $business) }}">
                                                <div class="mdc-switch mdc-switch--checked" data-mdc-auto-init="MDCSwitch">
                                                    <div class="mdc-switch__track"></div>
                                                    <div class="mdc-switch__thumb-underlay">
                                                        <div class="mdc-switch__thumb">
                                                            <input type="hidden" name="status" value="0">
                                                            <input type="checkbox" name="status"
                                                                id="bassic-status-switch-{{ $business->id }}"@if ($business->status) checked @endif
                                                                class="mdc-switch__native-control" role="switch"
                                                                value="1" onclick="this.form.submit()" />
                                                        </div>
                                                    </div>
                                                </div>
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <a href="#" onclick="goToVehicleBtn(event)"
                                                data-id="{{ $business->tin }}"
                                                class="btn btn-outline-info btn-sm mx-2">View</a>
                                            <a href="#" class="btn  btn-outline-danger mx-2"
                                                onclick="if(confirm('Are you sure want to delete {{ $business->name }}?')) document.getElementById('delete-business-{{ $business->id }}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-business-{{ $business->id }}" method="post"
                                                action="{{ route('vehicles.delete', $business) }}">@csrf
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
        function goToVehicleTr(event) {
            var tin = event.target.parentNode.dataset.id;
            window.location.href = '/business?tin=' + tin;
        }

        function goToVehicleBtn(event) {
            var tin = event.target.dataset.id;
            window.location.href = '/business?tin=' + tin;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('a i.material-icons').click(function() {
                var tin = $(this).closest('tr').data('id');
                $('#tin_input_' + tin).toggle();
                $('#tin_value_' + tin).toggle();
            });
        });
    </script>
@endsection
