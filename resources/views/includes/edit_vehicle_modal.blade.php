{{-- <div class="card">
    <div class="card-body">
        <form action="{{ route('vehicles.edit', $vehicle) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="" style="color:gray">Vehicle Info</div>
            <div class="row">
                <div class="col mb-2">
                    <label for="name" class=" col-form-label text-sm-start">{{ __('Vehicle Name') }}</label><span
                        class="text-danger"> *</span>
                    <div class="">
                        <input id="name" type="text" placeholder="Name"
                            class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $vehicle->name) }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col mb-2">
                    <label for="tin" class=" col-form-label text-sm-start">{{ __('Reg. Number') }}
                        <span class="text-danger"> *</span> </label>
                    <div class="">
                        <input readonly id="tin" type="number" placeholder="TIN" style="background: rgb(224, 237, 244); cursor:not-allowed"
                            class="form-control @error('tin') is-invalid @enderror" name="tin"
                            value="{{ old('tin', $vehicle->reg_number) }}"required autocomplete="tin" autofocus>
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
                            value="{{ old('nida', $vehicle->nida) }}"required autocomplete="nida" autofocus>
                        @error('nida')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col mb-2">
                    <label for="payerId" class=" col-form-label text-sm-start">{{ __("Payer's ID") }}</label><span
                        class="text-danger"> *</span>
                    <div class="">
                        <input id="payerId" type="number" placeholder="Payer's ID" required
                            class="form-control @error('payerId') is-invalid @enderror" name="payerId"
                            value="{{ old('payerId', $vehicle->payerId) }}" autocomplete="payerId" autofocus>
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
                    <label for="type_id" class=" col-form-label text-sm-start">{{ __('Vehicle Type') }}
                        <span class="text-danger"> *</span></label>

                    @error('type_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="col mb-2">
                    <label for="email" class=" col-form-label text-sm-start">{{ __('Email') }}
                        <span class="text-danger"> *</span> </label>
                    <div class="">
                        <input id="email" type="email" placeholder="me@vehicle.com"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', $vehicle->email) }}"required autocomplete="email" autofocus>
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
                        class="form-control form-select @error('province_id') is-invalid @enderror" name="province_id"
                        value="{{ old('province_id') }}" required autocomplete="province_id" autofocus>
                        <option value="">Choose Province</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}"
                                {{ $province->id == $vehicle->province->id ? 'selected' : '' }}>

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
                            <option value="{{ $ward->id }}"
                                {{ $ward->id == $vehicle->ward->id ? 'selected' : '' }}>

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
                        name="sub_ward_id" value="{{ old('sub_ward_id') }}" required autocomplete="sub_ward_id"
                        autofocus>
                        <option value="">Choose Sub-Ward</option>
                        @foreach ($subWards as $subWard)
                            <option value="{{ $subWard->id }}"
                                {{ $subWard->id == $vehicle->subWard->id ? 'selected' : '' }}>

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
                        class="form-control @error('street_name') is-invalid @enderror" name="street_name"
                        value="" required list="streets">
                    <datalist id="streets">
                        @foreach ($streets as $street)
                            <option value="{{ $street->name }}"
                                {{ $street->name == $vehicle->street->name ? 'selected' : '' }}>
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
                            value="{{ old('address', $vehicle->address) }}"required autocomplete="address"
                            autofocus>
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
                            value="{{ old('latitude', $vehicle->location->latitude) }}" autocomplete="latitude"
                            autofocus>
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
                            value="{{ old('longitude', $vehicle->location->longitude) }}" autocomplete="longitude"
                            autofocus>
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
                            class="form-control @error('house_number') is-invalid @enderror" name="house_number"
                            value="{{ old('house_number', $vehicle->house_number) }}"
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
            <div class="row mb-2 mt-2">
                <div class="text-center">
                    <button type="submit" class="btn  btn-outline-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div> --}}
