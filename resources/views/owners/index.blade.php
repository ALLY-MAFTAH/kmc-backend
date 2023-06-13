@extends('layouts.app')

@section('title')
    Owners
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
                                        <small>{{ __('Owners') . ' - ' }}
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $owners->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col text-right">
                            <a href="#" class="btn  btn-outline-primary collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                                <i class="feather icon-plus"></i> Add New Owner
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                                <form method="POST" action="{{ route('owners.add') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-1">
                                            <label for="first_name"
                                                class=" col-form-label text-sm-start">{{ __('First Name') }}
                                            </label> <span class="text-danger"> *</span>
                                            <div class="">
                                                <input id="first_name" type="text" placeholder="First Name"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    name="first_name" value="{{ old('first_name') }}"required
                                                    autocomplete="first_name" autofocus>
                                                @error('first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-1">
                                            <label for="middle_name"
                                                class=" col-form-label text-sm-start">{{ __('Middle Name') }}
                                            </label> <span class="text-danger"> </span>
                                            <div class="">
                                                <input id="middle_name" type="text" placeholder="Middle Name"
                                                    class="form-control @error('middle_name') is-invalid @enderror"
                                                    name="middle_name" value="{{ old('middle_name') }}"
                                                    autocomplete="middle_name" autofocus>
                                                @error('middle_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-1">
                                            <label for="last_name"
                                                class=" col-form-label text-sm-start">{{ __('Last Name') }}
                                            </label> <span class="text-danger"> *</span>
                                            <div class="">
                                                <input id="last_name" type="text" placeholder="Last Name"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    name="last_name" value="{{ old('last_name') }}"required
                                                    autocomplete="last_name" autofocus>
                                                @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col mb-1">
                                            <label for="nida" class=" col-form-label text-sm-start">{{ __('NIDA') }}
                                            </label> <span class="text-danger"> *</span>
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
                                        <div class="col mb-1">
                                            <label for="mobile" class=" col-form-label text-sm-start">{{ __('Phone') }}
                                            </label> <span class="text-danger"> *</span>
                                            <div class="">
                                                <input id="mobile" type="number" placeholder="Eg; 0712345678"
                                                    maxlength="10" pattern="0[0-9]{9}"
                                                    class="form-control @error('mobile') is-invalid @enderror"
                                                    name="mobile" value="{{ old('mobile') }}"required
                                                    autocomplete="phone" autofocus>
                                                @error('mobile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-1">
                                            <label for="photo"
                                                class=" col-form-label text-sm-start">{{ __('Profile Photo') }}
                                            </label> <span class="text-danger"> *</span>
                                            <div class="">
                                                <input id="photo" type="file" accept=".jpg,.png,.jpeg,.gif"
                                                    class="form-control @error('photo') is-invalid @enderror"
                                                    name="photo" value="{{ old('photo') }}" required>
                                                @error('photo')
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
                                    <th>Photo</th>
                                    <th>Full Name</th>
                                    <th>NIDA</th>
                                    <th>Mobile</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($owners as $index => $owner)
                                    <tr>
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>
                                            
                                            <div class="profile-image">
                                                <img height="40px" width="40px"
                                                    src="{{ asset('storage/' . $owner->photo) }}" alt="Profile image">
                                            </div>
                                        </td>

                                        <td>{{ $owner->first_name }} {{ $owner->middle_name }} {{ $owner->last_name }}
                                        </td>
                                        <td>{{ $owner->nida }}</td>
                                        <td>{{ $owner->mobile }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('owners.show', $owner) }}"
                                                class="btn btn-outline-info mx-2">View</a>

                                            <a href="#" class="btn  btn-outline-primary mx-2" type="button"
                                                data-bs-toggle="modal" data-bs-target="#editModal-{{ $owner->id }}"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                Edit
                                            </a>

                                            <a href="#" class="btn  btn-outline-danger mx-2"
                                                onclick="if(confirm('Are you sure want to delete {{ $owner->name }}?')) document.getElementById('delete-owner-{{ $owner->id }}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-owner-{{ $owner->id }}" method="post"
                                                action="{{ route('owners.delete', $owner) }}">@csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                        <div class="modal modal-lg fade" id="editModal-{{ $owner->id }}"
                                            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Owner
                                                        </h5>
                                                        <button type="button" class="btn btn-danger btn-sm btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @include('includes.edit_owner_modal')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@endsection
