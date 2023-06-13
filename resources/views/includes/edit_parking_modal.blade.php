<div class="card">
    <div class="card-body">
        <form action="{{ route('parkings.edit', $parking) }}" method="POST">
            @method('PUT')
            @csrf
            <br>
            <div class="" style="color:gray">Parking Info</div>
            <input type="number" name="parking_id" value="{{ $parking->id }}" hidden>
            <input type="text" name="location_name" value="{{ $parking->location->location_name }}" hidden>
            <input type="text" name="longitude" value="{{ $parking->location->longitude }}" hidden>
            <input type="text" name="latitude" value="{{ $parking->location->latitude }}" hidden>
            <input type="text" name="leader_photo" value="{{ $parking->leader_photo }}" hidden>
            <div class="row">
                <div class="col mb-2">
                    <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}
                        <span class="text-danger"> *</span> </label>
                    <div class="">
                        <input id="name" type="name" placeholder="Name"
                            class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $parking->name) }}"required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-2 mb-2">
                    <label for="capacity" class=" col-form-label text-sm-start">{{ __('Capacity') }}
                        <span class="text-danger"> *</span> </label>
                    <div class="">
                        <input id="capacity" type="text" placeholder="Capacity"
                            class="form-control @error('capacity') is-invalid @enderror" name="capacity"
                            value="{{ old('capacity', $parking->capacity) }}"required autocomplete="capacity" autofocus>
                        @error('capacity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col mb-2">
                    <label for="leader_name" class=" col-form-label text-sm-start">{{ __('Leader Name') }}
                        <span class="text-danger"> *</span> </label>
                    <div class="">
                        <input id="leader_name" type="text" placeholder="Leader Name"
                            class="form-control @error('leader_name') is-invalid @enderror" name="leader_name"
                            value="{{ old('leader_name', $parking->leader_name) }}"required autocomplete="leader_name"
                            autofocus>
                        @error('leader_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col mb-2">
                    <label for="leader_mobile" class=" col-form-label text-sm-start">{{ __('Leader Mobile') }}
                        <span class="text-danger"> *</span> </label>
                    <div class="">
                        <input id="leader_mobile" type="text" placeholder="Capacity"
                            class="form-control @error('leader_mobile') is-invalid @enderror" name="leader_mobile"
                            value="{{ old('leader_mobile', $parking->leader_mobile) }}"required
                            autocomplete="leader_mobile" autofocus>
                        @error('leader_mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
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
                        class="form-control form-select @error('sub_ward_id') is-invalid @enderror" name="sub_ward_id"
                        value="{{ old('sub_ward_id') }}" required autocomplete="sub_ward_id" autofocus>
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
                        class="form-control @error('street_name') is-invalid @enderror" name="street_name"
                        value="" required list="streets" autocomplete="off">
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
