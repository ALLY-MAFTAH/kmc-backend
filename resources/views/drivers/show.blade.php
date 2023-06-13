@extends('layouts.app')

@section('title')
    Driver
@endsection

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper px-2">
            <div class="row">
                <div class="col-md-7 pb-2">
                    <div class="card shadow px-2 pt-3">
                        <div class="row">
                            <div class="col-3 leftProfSide">
                                <div class="ml-2"
                                    style="width: 150px; height: 150px; overflow: hidden; border-radius: 50%; border: 1px solid rgb(0, 132, 255);">
                                    <img src="{{ asset('storage/' . $driver->photo) }}" alt="" style="width: 100%;"
                                        onerror="this.onerror=null; this.src='{{ asset('../images/user.png') }}';">
                                </div>

                                <div class="contBtns py-3 ml-2">
                                    <button href="#" data-bs-toggle="modal"
                                        data-bs-target="#messageModal-{{ $driver->id }}" class=" text-center contactBtn"
                                        type="button"><i class="material-icons" style="">message</i>MESSAGE</button>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-5">
                                        <h5 class="my-0">
                                            <span style="color:rgb(188, 186, 186)">NIDA: </span>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0" style="color:rgb(3, 3, 87)">
                                            <span>{{ $driver->nida }}</span>
                                        </h5>
                                    </div>

                                </div>
                                <hr style="margin-top: 5px;margin-bottom: 5px;">
                                <div class="row">
                                    <div class="col-5 pb-3">
                                        <h5 class="my-0">
                                            <div style="color:rgb(188, 186, 186)">First Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Middle Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Last Name: </div>
                                            <div style="color:rgb(188, 186, 186)">Mobile: </div>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0">
                                            <div>{{ $driver->first_name }}</div>
                                            <div>
                                                {{ $driver->middle_name ? $driver->middle_name : ' - ' }}
                                            </div>
                                            <div>{{ $driver->last_name }}</div>
                                            <div>{{ $driver->mobile }}</div>

                                        </h5><br>
                                        <div class="pt-4">
                                            <button href="#" data-bs-toggle="modal"style="width:150px"
                                                data-bs-target="#edit_driver_modal-{{ $driver->id }}"
                                                class=" text-center editBtn" type="button"><i
                                                    class="material-icons">edit</i>EDIT</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 pb-2">
                    <div class="card shadow">
                        <div class="text-center">Summary</div>
                        <div class="row px-2 pt-2">
                            <div class="col text-center"style="border-right: 1px dashed #333;">
                                <i class="material-icons" style="font-size: 40px;color:rgb(234, 20, 241)">receipt</i>
                                <div class="">
                                    <b> {{ $driver->vehicles->count() }}</b>
                                </div>
                                <div class="">
                                    VEHICLES
                                </div>
                            </div>
                            <div class="col text-center"style="border-right: 1px dashed #333;">
                                <i class="material-icons" style="font-size: 40px;color:rgb(32, 12, 251)">attach_money</i>
                                <div class="">
                                    <b> {{ number_format($amount, 0, '.', ',') }}</b> TZS
                                </div>
                                <div class="">
                                    CONTRIBUTION
                                </div>
                            </div>
                            <div class="col text-center">
                                <i class="material-icons" style="font-size: 40px;color:rgb(244, 149, 7)">message</i>
                                <div class="">
                                    <b> {{ $driver->alerts->count() }}</b>
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
                    Vehicles
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3 table table-hover"style="width: 100%">
                            <thead class=" table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Reg. Number</th>
                                    <th>Type</th>
                                    <th>Brand</th>
                                    <th>Color</th>
                                    <th>PLN</th>
                                    <th>Owner</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($driver->vehicles as $index => $vehicle)
                                    <tr>
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td><span class="text-primary" onclick="goToVehicleBtn(event)"
                                                data-id="{{ $vehicle->reg_number }}"
                                                style="cursor: pointer">{{ $vehicle->reg_number }}
                                            </span>
                                        </td>
                                        <td>{{ $vehicle->type }}</td>
                                        <td>{{ $vehicle->brand }}</td>
                                        <td>{{ $vehicle->color }}</td>
                                        <td><a href="{{ route('parkings.show', $vehicle->parking->id) }}"
                                                style="text-decoration: none">{{ $vehicle->parking->pln }}</a></td>
                                        <td><a href="{{ route('owners.show', $vehicle->owner->id) }}"
                                                style="text-decoration: none">
                                                {{ $vehicle->owner->first_name }} {{ $vehicle->owner->middle_name }}
                                                {{ $vehicle->owner->last_name }}</a>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('vehicles.show') }}" method="GET">
                                                @csrf
                                                <input type="text" value="{{ $vehicle->reg_number }}" name="reg_number"
                                                    hidden>
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
                                @foreach ($driver->alerts as $index => $alert)
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

        <div class="modal modal-sm fade" id="messageModal-{{ $driver->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Message
                        </h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('send-message') }}">
                            @csrf
                            <input hidden type="text" name="driver_id" value="{{ $driver->id }}">
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
        <div class="modal modal-lg fade" id="edit_driver_modal-{{ $driver->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Driver Info
                        </h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('includes.edit_driver_modal')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-lg fade" id="mapModal-{{ $driver->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $driver->name }} Location
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
        function goToVehicleBtn(event) {
            var reg_number = event.target.dataset.id;
            window.location.href = '/vehicle?reg_number=' + reg_number;
        }
    </script>
@endsection
