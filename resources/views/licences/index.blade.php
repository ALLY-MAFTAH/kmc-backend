@extends('layouts.app')

@section('title')
    Licences
@endsection

@section('style')
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
                                        <small>{{ __('Business Licences Subjected to Kinondoni Municipal') . ' - ' }}
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $licences->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <form action="{{ route('licences.index') }}" method="GET" id="filter-form">
                                @csrf
                                <div class="input-group">
                                    <label for="licence_status" class=" col-form-label">Licence Status:
                                    </label>
                                    <select name="licence_status" id="licence_status" class="form-select  mx-1 form-control"
                                        style="border-radius:0.375rem;" onchange="this.form.submit()">
                                        <option
                                            value='All Licences'{{ $licence_status == 'All Licences' ? 'selected' : '' }}>
                                            All Licences </option>
                                        <option value='1'{{ $licence_status == '1' ? 'selected' : '' }}>
                                            Valid Licences </option>
                                        <option value='0'{{ $licence_status == '0' ? 'selected' : '' }}>
                                            Expired Licences </option>

                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3 table table-hover"style="width: 100%">
                            <thead class=" table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Number</th>
                                    <th>Owner (TIN)</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th class="text-center">Validity</th>
                                    <th>Receipt Number</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($licences as $index => $licence)
                                    <tr>
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td class="text-start">{{ $licence->number }}</td>
                                        <td class="text-start">
                                            @if ($licence->business)
                                                <span onclick="goToBusiness(event)" data-id="{{ $licence->business->tin }}"
                                                    style="cursor: pointer" class="text-primary">
                                                    {{ $licence->business->tin }}</span>
                                            @else
                                                <span class="text-danger">Deleted Business</span>
                                            @endif
                                        </td>
                                        <td class="text-start">
                                            {{ Illuminate\Support\Carbon::parse($licence->start_date)->format('d M Y') }}
                                        </td>
                                        <td class="text-start">
                                            {{ Illuminate\Support\Carbon::parse($licence->end_date)->format('d M Y') }}
                                        </td>

                                        <td class="text-center">
                                            @if ($licence->is_valid)
                                                <label for="" class="mx-1 px-1"
                                                    style="background-color:rgba(203, 253, 203, 0.833);color:green">VALID</label>
                                            @else
                                                <label for="" class="mx-1 px-1"
                                                    style="background-color:rgba(251, 190, 190, 0.825);color:red">EXPIRED</label>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $licence->payment->receipt_number }}
                                        </td>

                                        <td class="text-center">
                                            <form id="toggle-status-form-{{ $licence->id }}" method="POST" class="mx-3"
                                                action="{{ route('licences.toggle-status', $licence) }}">
                                                <div class="mdc-switch mdc-switch--checked" data-mdc-auto-init="MDCSwitch">
                                                    <div class="mdc-switch__track"></div>
                                                    <div class="mdc-switch__thumb-underlay">
                                                        <div class="mdc-switch__thumb">
                                                            <input type="hidden" name="status" value="0">
                                                            <input type="checkbox" name="status"
                                                                id="bassic-status-switch-{{ $licence->id }}"@if ($licence->status) checked @endif
                                                                class="mdc-switch__native-control" role="switch"
                                                                value="1" onclick="this.form.submit()" />
                                                        </div>
                                                    </div>
                                                </div>
                                                @csrf
                                                @method('PUT')
                                            </form>
                                            <a href="{{ route('licences.show', $licence) }}"
                                                class="btn btn-outline-info btn-sm mx-1">View</a>

                                            <a href="#" class="btn  btn-outline-primary mx-1" type="button"
                                                data-bs-toggle="modal" data-bs-target="#editModal-{{ $licence->id }}"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                Edit
                                            </a>
                                            <div class="modal modal-sm fade" id="editModal-{{ $licence->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Licence
                                                            </h5>
                                                            <button type="button" class="btn btn-danger btn-sm btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('licences.edit', $licence) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="text-start mb-1">
                                                                    <label for="name"
                                                                        class="col-form-label text-sm-start">{{ __('Name') }}</label>
                                                                    <input id="name" type="text"
                                                                        placeholder="Name"
                                                                        class="form-control @error('name') is-invalid @enderror"
                                                                        name="name"
                                                                        value="{{ old('name', $licence->name) }}" required
                                                                        autocomplete="name" autofocus>
                                                                    @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="text-start mb-1">
                                                                    <label for="description"
                                                                        class="col-form-label text-sm-start">{{ __('Description') }}</label>
                                                                    <input id="description" type="text"
                                                                        placeholder="Description"
                                                                        class="form-control @error('description') is-invalid @enderror"
                                                                        name="description"
                                                                        value="{{ old('description', $licence->description) }}"
                                                                        autocomplete="description" autofocus>
                                                                    @error('description')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="row mb-1 mt-2">
                                                                    <div class="text-center">
                                                                        <button type="submit"
                                                                            class="btn  btn-primary">
                                                                            {{ __('Submit') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn  btn-outline-danger mx-1"
                                                onclick="if(confirm('Are you sure want to delete {{ $licence->name }}?')) document.getElementById('delete-licence-{{ $licence->id }}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-licence-{{ $licence->id }}" method="post"
                                                action="{{ route('licences.delete', $licence) }}">@csrf
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
        function goToBusiness(event) {
            var tin = event.target.dataset.id;
            window.location.href = '/business?tin=' + tin;
        }
    </script>
@endsection
