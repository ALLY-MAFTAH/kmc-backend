@extends('layouts.app')

@section('title')
    Parking
@endsection

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper px-2">
            <div class="row">
                <div class="col-md-6 pb-2">
                    <div class="card shadow px-2 pt-3">
                        <div class="row">
                            <div class="col-3 leftProfSide">
                                <div class="ml-2"
                                    style="width: 120px; height: 120px; overflow: hidden; border-radius: 50%; border: 1px solid rgb(0, 132, 255);">
                                    <img src="{{ asset('storage/' . $parking->leader_photo) }}" alt=""
                                        style="width: 100%;"
                                        onerror="this.onerror=null; this.src='{{ asset('../images/user.png') }}';">
                                </div>
                                <div style="position: absolute; padding-left:85px">
                                    <form id="change_profile_form"
                                        action="{{ route('parkings.change_profile', $parking->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="bg-white text-center"
                                            style="width: 37px; height: 37px; overflow: hidden; border-radius: 50%; border: 1px solid rgb(0, 132, 255); display: flex; align-items: center; justify-content: center;">
                                            <label for="leader_photo">
                                                <i class="material-icons pt-1"
                                                    style="font-size:30px;color:rgb(0, 140, 255)">photo_camera</i>
                                            </label>
                                        </div>

                                        <input id="leader_photo" type="file" name="leader_photo" hidden
                                            accept=".jpg,.png,.jpeg,.gif" onchange="changeProfile()">
                                    </form>
                                </div>

                                <div class="contBtns py-3 ml-2">
                                    <button href="#" data-bs-toggle="modal"
                                        data-bs-target="#messageModal-{{ $parking->id }}" class=" text-center contactBtn"
                                        type="button"><i class="material-icons" style="">message</i>MESSAGE</button>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-5">
                                        <h5 class="my-0">
                                            <span style="color:rgb(188, 186, 186)">PLN: </span>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="my-0" style="color:rgb(3, 3, 87)">
                                                    <span>{{ $parking->pln }}</span>
                                                </h5>
                                            </div>
                                            <div class="col text-right">
                                                <a href="#" data-bs-toggle="modal"style="text-decoration:none"
                                                    data-bs-target="#edit_parking_modal-{{ $parking->id }}"
                                                    class=" text-center" type="a"><i
                                                        class="material-icons">edit</i></a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <hr style="margin-top: 5px;margin-bottom: 5px;">
                                <div class="row">
                                    <div class="col-5 pb-3">
                                        <h5 class="my-0">
                                            <div style="color:rgb(188, 186, 186)">Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Capacity: </div>
                                            <div style="color:rgb(188, 186, 186)">Active Vehicles: </div>
                                            <div style="color:rgb(188, 186, 186)">Leader Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Leader Mobile: </div>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0">
                                            <div>{{ $parking->name }}</div>
                                            <div>{{ $parking->capacity }}</div>
                                            <div>{{ $parking->no_of_vehicles }}</div>
                                            <div>{{ $parking->leader_name }}</div>
                                            <div>{{ $parking->leader_mobile }}</div>

                                        </h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 pb-2">
                    <div class="card shadow">
                        <div class="card-header text-center">
                            Location
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 pb-3">
                                    <h6 class="my-0">
                                        <div style="color:rgb(188, 186, 186)">Longitude: </div>
                                        <div style="color:rgb(188, 186, 186)">Latitude: </div>
                                        <div style="color:rgb(188, 186, 186)">Address: </div>
                                        <div style="color:rgb(188, 186, 186)">SubWard: </div>
                                        <div style="color:rgb(188, 186, 186)">Ward: </div>
                                    </h6>
                                </div>
                                <div class="col-7">
                                    <h6 class="my-0">
                                        <div>{{ $parking->location->longitude }}</div>
                                        <div>{{ $parking->location->latitude }}</div>
                                        <div>{{ $parking->location->location_name }}</div>
                                        <div>{{ $parking->ward }}</div>
                                        <div>{{ $parking->sub_ward}}</div>

                                    </h6>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 pb-2">
                    <div class="card shadow">
                        <div class="card-header text-center">Summary</div>
                        <div class="row px-2 pt-2">
                            <div class="col text-center"style="border-right: 1px dashed #333;">
                                <i class="material-icons" style="font-size: 40px;color:rgb(32, 12, 251)">attach_money</i>
                                <div class="">
                                    <b> {{ number_format($amount, 0, '.', ',') }}</b> TZS
                                </div>
                                <div class="">
                                    CONTRIBUTION
                                </div>
                            </div>
                            <div class="col text-center"style="">
                                <i class="material-icons" style="font-size: 40px;color:rgb(234, 20, 241)">message</i>
                                <div class="">
                                    <b> {{ $parking->alerts->count() }}</b>
                                </div>
                                <div class="">
                                    MESSAGES
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <br>

            <div class="card">
                <div class="card-header  text-center" style="font-size: 20px">
                    Vehicles ({{ $parking->vehicles->count() }})
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3 table table-hover"style="width: 100%">
                            <thead class=" table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Registration Number</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Color</th>
                                    <th>Owner</th>
                                    <th>Driver</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parking->vehicles as $index => $vehicle)
                                    <tr>
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>{{ $vehicle->reg_number }}</td>
                                        <td>{{ $vehicle->type }}</td>
                                        <td>{{ $vehicle->brand }}</td>
                                        <td>{{ $vehicle->color }}</td>
                                        <td>

                                            <form action="{{ route('owners.show') }}" method="GET">
                                                <input type="number" name="owner_id" value="{{ $vehicle->owner->id }}"
                                                    hidden>
                                                <button type="submit"class="btn text-primary"
                                                    style="text-decoration: none">
                                                    {{ $vehicle->owner->first_name }} {{ $vehicle->owner->middle_name }}
                                                    {{ $vehicle->owner->last_name }}</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('drivers.show') }}" method="GET">
                                                <input type="number" name="driver_id" value="{{ $vehicle->driver->id }}"
                                                    hidden>
                                                <button type="submit"class="btn text-primary"
                                                    style="text-decoration: none">
                                                    {{ $vehicle->driver->first_name }} {{ $vehicle->driver->middle_name }}
                                                    {{ $vehicle->driver->last_name }}</button>
                                            </form>

                                            {{-- <a href="{{ route('drivers.show', $vehicle->driver->id) }}"
                                                style="text-decoration: none">
                                                {{ $vehicle->driver->first_name }} {{ $vehicle->driver->middle_name }}
                                                {{ $vehicle->driver->last_name }}</a> --}}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('vehicles.show') }}" method="GET">
                                                @csrf
                                                <input type="text" value="{{ $vehicle->reg_number }}"
                                                    name="reg_number" hidden>
                                                <button class="btn  btn-outline-primary mx-1" type="submit">
                                                    View
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header  text-center" style="font-size: 20px">
                    Messages
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo2"
                            class="dt-responsive nowrap shadow rounded-3 table table-hover"style="width: 100%">
                            <thead class=" table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Phone</th>
                                    <th>Message Body</th>
                                    {{-- <th class="text-center">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parking->alerts as $index => $alert)
                                    <tr>
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>{{ $alert->date }}</td>
                                        <td>{{ $alert->category }}</td>
                                        <td>{{ $alert->mobile }}</td>
                                        <td>{{ $alert->msg }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <div class="modal modal-sm fade" id="messageModal-{{ $parking->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Message
                        </h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            @csrf
                            <input hidden type="text" name="parking_id" value="{{ $parking->id }}">
                            <div class="text-start mb-1">
                                <label for="body" class="col-form-label text-sm-start">{{ __('Body') }}</label>
                                <textarea rows="3" id="body" type="text" placeholder="Body"
                                    class="form-control @error('body') is-invalid @enderror" name="body" autocomplete="body" required autofocus></textarea>
                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-1 mt-2">
                                <div class="text-center">
                                    <button type="submit" class="btn  btn-outline-primary">
                                        {{ __('Send Message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-lg fade" id="edit_parking_modal-{{ $parking->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Parking Info
                        </h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('includes.edit_parking_modal')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-lg fade" id="mapModal-{{ $parking->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $parking->name }} Location
                        </h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126792.51368090636!2d38.9826250076294!3d-6.737363608470637!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c5b0dcd3c8ea3%3A0x55e6f7d7fd250745!2sTegeta%20A%20Kahama%20street!5e0!3m2!1sen!2stz!4v1675687860167!5m2!1sen!2stz"
                            width="760" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#start_date").change(function() {
                var start_date = new Date($(this).val());
                var end_date = new Date(start_date);
                end_date.setFullYear(end_date.getFullYear() + 1);
                end_date.setDate(end_date.getDate() - 1);
                $("#end_date").val(end_date.toISOString().substring(0, 10));
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#province_id").change(function(e) {
                e.preventDefault();
                var provinceId = $(this).val();
                $.ajax({
                    url: '/get-wards',
                    type: 'GET',
                    data: {
                        provinceId: provinceId
                    },
                    success: function(data) {
                        console.log(data.filteredWards);
                        $("#ward_id").html(""); // clear the options
                        $("#ward_id").html(data.filteredWards);
                    }
                });
            });
        });
        $(document).ready(function() {
            $("#ward_id").change(function(e) {
                e.preventDefault();
                var wardId = $(this).val();
                $.ajax({
                    url: '/get-sub-wards',
                    type: 'GET',
                    data: {
                        wardId: wardId
                    },
                    success: function(data) {
                        console.log(data.filteredSubWards);
                        $("#sub_ward_id").html(""); // clear the options
                        $("#sub_ward_id").html(data.filteredSubWards);
                    }
                });
            });
        });
        $(document).ready(function() {
            $("#sub_ward_id").change(function(e) {
                e.preventDefault();
                var subWardId = $(this).val();
                $.ajax({
                    url: '/get-streets',
                    type: 'GET',
                    data: {
                        subWardId: subWardId
                    },
                    success: function(data) {
                        console.log(data.filteredStreets);
                        $("#streets").html(""); // clear the options
                        $("#streets").html(data.filteredStreets);
                    }
                });
            });
        });
    </script>
    <script>
        function changeProfile() {
            document.getElementById("change_profile_form").submit();
        }
    </script>
@endsection
