@extends('layouts.app')

@section('title')
    Sub-Ward - {{$subWard->name}}
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
                                        <small>Streets under {{ $subWard->name }} sub-ward -
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $subWard->streets->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col text-right">
                            <a href="#" class="btn  btn-outline-primary collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">

                                <i class="feather icon-plus"></i> Add New Streets

                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                                <form method="POST" action="{{ route('streets.add') }}">
                                    @csrf
                                    <div class="row">
                                        <input hidden type="text" name="sub_ward_id" value="{{ $subWard->id }}">
                                        <div class="col mb-1">
                                            <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}
                                                <span class="text-danger"> *</span> </label>
                                            <div class="">
                                                <input id="name" type="text" placeholder="Name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}"required autocomplete="name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-1">
                                            <label for="description"
                                                class=" col-form-label text-sm-start">{{ __('Description') }}</label>
                                            <div class="">
                                                <input id="description" type="text" placeholder="Description"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    name="description" value="{{ old('description') }}"
                                                    autocomplete="description" autofocus>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 mt-2">
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
                            <thead class=" table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-center">Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subWard->streets as $index => $street)
                                    <tr>
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>{{ $street->name }}</td>
                                        <td>{{ $street->description }}</td>
                                        <td class="text-center">
                                            <form id="toggle-status-form-{{ $street->id }}" method="POST"
                                                action="{{ route('streets.toggle-status', $street) }}">
                                                <div class="mdc-switch mdc-switch--checked" data-mdc-auto-init="MDCSwitch">
                                                    <div class="mdc-switch__track"></div>
                                                    <div class="mdc-switch__thumb-underlay">
                                                        <div class="mdc-switch__thumb">
                                                            <input type="hidden" name="status" value="0">
                                                            <input type="checkbox" name="status"
                                                                id="bassic-status-switch-{{ $street->id }}"@if ($street->status) checked @endif
                                                                class="mdc-switch__native-control" role="switch"
                                                                value="1" onclick="this.form.submit()" />
                                                        </div>
                                                    </div>
                                                </div>
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </td>
                                        <td class="text-center d-flex justify-content-between text-center">
                                            <a href="{{ route('streets.show', $street) }}"
                                                class="btn btn-outline-info btn-sm mx-2">View</a>

                                            <a href="#" class="btn  btn-outline-primary mx-2" type="button"
                                                data-bs-toggle="modal" data-bs-target="#editModal-{{ $street->id }}"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                Edit
                                            </a>
                                            <div class="modal modal-sm fade" id="editModal-{{ $street->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Province
                                                            </h5>
                                                            <button type="button" class="btn btn-danger btn-sm btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('streets.edit', $street) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="text-start mb-1">
                                                                    <label for="name"
                                                                        class="col-form-label text-sm-start">{{ __('Name') }}</label>
                                                                    <input id="name" type="text"
                                                                        placeholder="Name"
                                                                        class="form-control @error('name') is-invalid @enderror"
                                                                        name="name"
                                                                        value="{{ old('name', $street->name) }}"
                                                                        required autocomplete="name" autofocus>
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
                                                                        value="{{ old('description', $street->description) }}"
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
                                            <a href="#" class="btn  btn-outline-danger mx-2"
                                                onclick="if(confirm('Are you sure want to delete {{ $street->name }}?')) document.getElementById('delete-street-{{ $street->id }}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-street-{{ $street->id }}" method="post"
                                                action="{{ route('streets.delete', $street) }}">@csrf
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
@section('script')
@endsection
