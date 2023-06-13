<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('drivers.edit', $driver) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="text-start col mb-1">
                    <label for="first_name" class=" col-form-label text-sm-start">{{ __('First Name') }}
                    </label> <span class="text-danger"> *</span>
                    <div class="">
                        <input id="first_name" type="text" placeholder="First Name"
                            class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                            value="{{ old('first_name', $driver->first_name) }}"required autocomplete="first_name"
                            autofocus>
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="text-start col mb-1">
                    <label for="middle_name" class=" col-form-label text-sm-start">{{ __('Middle Name') }}
                    </label> <span class="text-danger"> </span>
                    <div class="">
                        <input id="middle_name" type="text" placeholder="Middle Name"
                            class="form-control @error('middle_name') is-invalid @enderror" name="middle_name"
                            value="{{ old('middle_name', $driver->middle_name) }}" autocomplete="middle_name" autofocus>
                        @error('middle_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-start col mb-1">
                    <label for="last_name" class=" col-form-label text-sm-start">{{ __('Last Name') }}
                    </label> <span class="text-danger"> *</span>
                    <div class="">
                        <input id="last_name" type="text" placeholder="Last Name"
                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                            value="{{ old('last_name', $driver->last_name) }}"required autocomplete="last_name"
                            autofocus>
                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="text-start col mb-1">
                    <label for="nida" class=" col-form-label text-sm-start">{{ __('NIDA') }}
                    </label> <span class="text-danger"> *</span>
                    <div class="">
                        <input id="nida" type="number" placeholder="NIDA"
                            class="form-control @error('nida') is-invalid @enderror" name="nida"
                            value="{{ old('nida', $driver->nida) }}"required autocomplete="nida" autofocus>
                        @error('nida')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-start col mb-1">
                    <label for="mobile" class=" col-form-label text-sm-start">{{ __('Phone') }}
                    </label> <span class="text-danger"> *</span>
                    <div class="">
                        <input id="mobile" type="number" placeholder="Eg; 0712345678" maxlength="10"
                            pattern="0[0-9]{9}" class="form-control @error('mobile') is-invalid @enderror"
                            name="mobile" value="{{ old('mobile', $driver->mobile) }}"required autocomplete="phone"
                            autofocus>
                        @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="text-start col mb-1">
                    <label for="photoEdit" class=" col-form-label text-sm-start">{{ __('Profile Photo') }}
                    </label> <span class="text-danger"> *</span>
                    <div class="">
                        <input id="photo" type="file" accept=".jpg,.png,.jpeg,.gif"
                            class="form-control @error('photo') is-invalid @enderror" name="photo"
                            value="{{ old('photo') }}">
                        <span>{{ $driver->photo }}</span>
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
