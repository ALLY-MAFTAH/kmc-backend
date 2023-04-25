@extends('layouts.app')

@section('title')
    Street - {{ $street->name }}
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
                                        <small>Parking under {{ $street->name }} street -
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $street->parkings->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <form action="{{ route('streets.show', $street) }}" method="GET" id="filter-form">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <select name="sticker_status" id="sticker_status"
                                                class="form-select  mx-1 form-control" style="border-radius:0.375rem;"
                                                onchange="this.form.submit()">
                                                <option
                                                    value='All Parkings'{{ $sticker_status == 'All Parkings' ? 'selected' : '' }}>
                                                    All Parkings </option>
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
                                                @foreach ($types as $type)
                                                    <option
                                                        value='{{ $type->id }}'{{ $type->id == $type_id ? 'selected' : '' }}>
                                                        {{ $type->name }} </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="col text-right">
                            <a href="#" class="btn  btn-outline-primary collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                                <i class="feather icon-plus"></i> Register New Parking
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3  table table-hover"style="width: 100%">
                            <thead class="table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Reg. Number</th>
                                    <th>Current Sticker No.</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Type</th>
                                    <th>Province</th>
                                    <th>Ward</th>
                                    <th>Sub-Ward</th>
                                    <th>Street</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($filteredParkings as $index => $parking)
                                    <tr ondblclick="goToParking(event)" data-id="{{ $parking->pln }}"
                                        style="cursor: pointer">
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>{{ $parking->pln }}</td>
                                        <td>{{ $parking->name }}</td>
                                        @if ($parking->stickers->last()->is_valid)
                                        <td>{{ $parking->stickers->last()->number }}</td>
                                    @else
                                        <td class="text-danger">{{ $parking->stickers->last()->number }}</td>
                                    @endif

                                        <td>{{ $parking->province->name }}</td>
                                        <td>{{ $parking->ward->name }}</td>
                                        <td>{{ $parking->subWard->name }}</td>
                                        <td>{{ $parking->street->name }}</td>
                                        <td class=" text-center">
                                            <form id="toggle-status-form-{{ $parking->id }}" method="POST"
                                                action="{{ route('parkings.toggle-status', $parking) }}">
                                                <div class="mdc-switch mdc-switch--checked" data-mdc-auto-init="MDCSwitch">
                                                    <div class="mdc-switch__track"></div>
                                                    <div class="mdc-switch__thumb-underlay">
                                                        <div class="mdc-switch__thumb">
                                                            <input type="hidden" name="status" value="0">
                                                            <input type="checkbox" name="status"
                                                                id="bassic-status-switch-{{ $parking->id }}"@if ($parking->status) checked @endif
                                                                class="mdc-switch__native-control" role="switch"
                                                                value="1" onclick="this.form.submit()" />
                                                        </div>
                                                    </div>
                                                </div>
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <a href="{{ route('parkings.show', $parking) }}"
                                                class="btn btn-outline-info btn-sm mx-2">View</a>
                                            <a href="#" class="btn  btn-outline-danger mx-2"
                                                onclick="if(confirm('Are you sure want to delete {{ $parking->name }}?')) document.getElementById('delete-parking-{{ $parking->id }}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-parking-{{ $parking->id }}" method="post"
                                                action="{{ route('parkings.delete', $parking) }}">@csrf
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
        function goToParking(event) {
            var tin = event.target.parentNode.dataset.id;
            window.location.href = '/parking?tin=' + tin;
        }
    </script>
@endsection
