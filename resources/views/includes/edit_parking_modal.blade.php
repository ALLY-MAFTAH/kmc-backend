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
                            value="{{ old('capacity', $parking->capacity) }}"required autocomplete="capacity"
                            autofocus>
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
                    <label for="ward" class=" col-form-label text-sm-start">{{ __('Ward') }}
                        <span class="text-danger"> *</span></label>
                    <select id="ward" type="number"
                        class="form-control form-select @error('ward') is-invalid @enderror" name="ward"
                        value="{{ old('ward') }}" required autocomplete="ward" autofocus>
                        @foreach (App\Helpers\ListHelper::wardsList() as $ward)
                            <option value="{{ $ward }}" {{ $ward == $parking->ward ? 'selected' : '' }}>
                                {{ $ward }}
                            </option>
                        @endforeach
                    </select>
                    @error('ward')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col mb-2">
                    <label for="sub_ward" class=" col-form-label text-sm-start">{{ __('Sub-Ward') }}
                        <span class="text-danger"> *</span></label>
                    <select id="sub_ward" type="number"
                        class="form-control form-select @error('sub_ward') is-invalid @enderror" name="sub_ward"
                        value="{{ old('sub_ward') }}" required autocomplete="sub_ward" autofocus>
                        @foreach (App\Helpers\ListHelper::subWardsList() as $subWard)
                            <option value="{{ $subWard }}" {{ $subWard == $parking->sub_ward ? 'selected' : '' }}>
                                {{ $subWard }}
                            </option>
                        @endforeach
                    </select>
                    @error('sub_ward')
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
