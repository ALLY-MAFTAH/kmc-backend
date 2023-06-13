<div class="card">
    <div class="card-body">
        <form action="{{ route('vehicles.edit', $vehicle) }}" method="POST">
            @method('PUT')
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
                            class="form-control @error('reg_number') is-invalid @enderror" name="reg_number"
                            value="{{ old('reg_number', $vehicle->reg_number) }}" required autocomplete="reg_number"
                            autofocus>
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
                            value="{{ old('brand', $vehicle->brand) }}"required autocomplete="brand" autofocus>
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
                            value="{{ old('color', $vehicle->color) }}"required autocomplete="color" autofocus>
                        @error('color')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col mb-2">
                    <label for="type" class=" col-form-label text-sm-start">{{ __('Vehicle Type') }}
                        <span class="text-danger"> *</span></label>
                    <select id="type" type="text"
                        class="form-control form-select @error('type') is-invalid @enderror" name="type"
                        value="{{ old('type') }}" required autocomplete="type" autofocus>
                        <option value="">--Choose Vehicle Type--</option>
                        <option value="Bajaji"{{ $vehicle->type == 'Bajaji' ? 'selected' : '' }}>Bajaji
                        </option>
                        <option value="Pikipiki"{{ $vehicle->type == 'Pikipiki' ? 'selected' : '' }}>
                            Pikipiki</option>
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
                    <label for="parking_id" class=" col-form-label text-sm-start">{{ __('Parking') }}
                        <span class="text-danger"> *</span></label>
                    <select id="parking_id" type="text"
                        class="form-control form-select @error('parking_id') is-invalid @enderror" name="parking_id"
                        value="{{ old('parking_id') }}" required autocomplete="parking_id" autofocus>
                        <option value="">--Choose Parking--</option>
                        @foreach ($parkings as $parking)
                            <option value="{{ $parking->id }}"
                                {{ $parking->id == $vehicle->parking_id ? 'selected' : '' }}>{{ $parking->pln }}
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
                    <label for="driver_id" class=" col-form-label text-sm-start">{{ __('Driver') }}
                        <span class="text-danger"> </span></label>
                    <select id="driver_id" type="text"
                        class="form-control form-select @error('driver_id') is-invalid @enderror" name="driver_id"
                        value="{{ old('driver_id') }}" autocomplete="driver_id" autofocus>
                        <option value="">--Choose Driver--</option>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}"
                                {{ $driver->id == $vehicle->driver_id ? 'selected' : '' }}>{{ $driver->first_name }}
                                {{ $driver->middle_name }} {{ $driver->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col mb-2">
                    <label for="owner_id" class=" col-form-label text-sm-start">{{ __('Owner') }}
                        <span class="text-danger"> </span></label>
                    <select id="owner_id" type="text"
                        class="form-control form-select @error('owner_id') is-invalid @enderror" name="owner_id"
                        value="{{ old('owner_id') }}" autocomplete="owner_id" autofocus>
                        <option value="">--Choose Owner--</option>
                        @foreach ($owners as $owner)
                            <option value="{{ $owner->id }}"
                                {{ $owner->id == $vehicle->owner_id ? 'selected' : '' }}>{{ $owner->first_name }}
                                {{ $owner->middle_name }} {{ $owner->last_name }}
                            </option>
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
