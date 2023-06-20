@extends('layouts.app')

@section('title')
    Vehicle
@endsection

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper px-2">
            <div class="row">
                <div class="col-md-6 pb-2">
                    <div class="card shadow px-2 pt-3">
                        <div class="row">
                            <div class="col-1 leftProfSide"> </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-5">
                                        <h5 class="my-0">
                                            <span style="color:rgb(188, 186, 186)">Reg. Number: </span>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0" style="color:rgb(3, 3, 87)">
                                            <span>{{ $vehicle->reg_number }}</span>
                                        </h5>
                                    </div>

                                </div>
                                <hr style="margin-top: 5px;margin-bottom: 5px;">
                                <div class="row">
                                    <div class="col-5 pb-3">
                                        <h5 class="my-0">
                                            <div style="color:rgb(188, 186, 186)">Brand: </div>
                                            <div style="color:rgb(188, 186, 186)">Type: </div>
                                            <div style="color:rgb(188, 186, 186)">Color: </div>
                                            <div style="color:rgb(188, 186, 186)">PLN: </div>
                                            <div style="color:rgb(188, 186, 186)">Driver: </div>
                                            <div style="color:rgb(188, 186, 186)">Owner: </div>
                                        </h5>
                                    </div>
                                    <div class="col-7">
                                        <h5 class="my-0">
                                            <div>{{ $vehicle->brand }}</div>
                                            <div>{{ $vehicle->type }}</div>
                                            <div>{{ $vehicle->color }}</div>
                                            <div>{{ $vehicle->parking->pln }}</div>
                                            @if ($vehicle->driver)
                                                <div>{{ $vehicle->driver->first_name }} {{ $vehicle->driver->middle_name }}
                                                    {{ $vehicle->driver->last_name }}</div>
                                            @else
                                                <div class="text-danger">
                                                    Not Assigned
                                                </div>
                                            @endif
                                            @if ($vehicle->owner)
                                                <div>{{ $vehicle->owner->first_name }} {{ $vehicle->owner->middle_name }}
                                                    {{ $vehicle->owner->last_name }}</div>
                                            @else
                                                <div class="text-danger">
                                                    Not Assigned
                                                </div>
                                            @endif

                                        </h5>
                                        <div class="pt-4">
                                            <button href="#" data-bs-toggle="modal"style="width:150px"
                                                data-bs-target="#edit_vehicle_modal-{{ $vehicle->id }}"
                                                class=" text-center editBtn" type="button"><i
                                                    class="material-icons">edit</i>EDIT</button>
                                        </div><br>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pb-2">
                    <div class="card shadow">
                        <div class="card-header text-center">Summary</div>
                        <div class="row px-2 pt-2">
                            <div class="col text-center"style="border-right: 1px dashed #333;">
                                <i class="material-icons" style="font-size: 40px;color:rgb(234, 20, 241)">receipt</i>
                                <div class="">
                                    <b> {{ $stickers->count() }}</b>
                                </div>
                                <div class="">
                                    STICKERS
                                </div>
                            </div>
                            <div class="col text-center"style="">
                                <i class="material-icons" style="font-size: 40px;color:rgb(32, 12, 251)">attach_money</i>
                                <div class="">
                                    <b> {{ number_format($amount, 0, '.', ',') }}</b> TZS
                                </div>
                                <div class="">
                                    CONTRIBUTION
                                </div>
                            </div>
                            {{-- <div class="col text-center">
                                <i class="material-icons" style="font-size: 40px;color:rgb(244, 149, 7)">message</i>
                                <div class="">
                                    <b> {{ $vehicle->alerts->count() }}</b>
                                </div>
                                <div class="">
                                    MESSAGES
                                </div>
                            </div> --}}
                        </div>
                        <br>
                        @if ($latestSticker->is_valid)
                            <div class="row mx-2"
                                style="background-color: rgba(203, 205, 245, 0.514); display: flex; align-items: center;">
                                <div class="col-7 text-center py-2">
                                    <b style="color:rgb(3, 3, 105)">CURRENT STICKER STATUS:
                                        <label class="p-1 valid-label">VALID</label>
                                    </b>
                                </div>
                                <div class="col-5 pt-1 text-center" style="font-size: 12px; color: rgb(8, 8, 110)">
                                    Expires on:
                                    {{ Illuminate\Support\Carbon::parse($latestSticker->end_date)->format('d M, Y') }}
                                </div>
                            </div>
                        @else
                            <div class="row mx-2" style="background-color: rgba(203, 205, 245, 0.514);">
                                <div class="col text-center py-2">
                                    <b style="color:rgb(3, 3, 105)">CURRENT STICKER STATUS:
                                        <label class=" p-1 invalid-label">EXPIRED</label>
                                    </b>
                                </div>
                            </div>
                        @endif
                        <div>
                            <div class="p-2">
                                @if ($latestSticker->is_valid)
                                    <div class="progress" style="height: 25px">
                                        <?php $startDate = Carbon\Carbon::createFromFormat('Y-m-d', $latestSticker->start_date);
                                        $endDate = Carbon\Carbon::createFromFormat('Y-m-d', $latestSticker->end_date);
                                        $now = Illuminate\Support\Carbon::now();
                                        $totalDays = $endDate->diffInDays($startDate);
                                        $remainingDays = $endDate->diffInDays($now);
                                        $width = 100 - ($remainingDays / $totalDays) * 100; ?>
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" style="width: {{ $width }}%" aria-valuemin="0"
                                            aria-valuemax="365">
                                        </div>
                                        <p class=""
                                            style="color: orange; text-shadow: 0.5px 0.5px white; position: absolute; left: 50%; transform: translateX(-50%);">
                                            {{ $remainingDays }} days remaining</p>
                                    </div>
                                @else
                                    <div class="text-center">

                                        <a href="#" class="btn btn-outline-primary btn-sm  collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#createNewSticker"
                                            aria-expanded="false" aria-controls="createNewSticker">Create New Sticker</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div id="createNewSticker" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                aria-labelledby="createNewSticker" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center" style="color:gray">
                                <h5>New Sticker</h5>
                                <hr>
                            </div>
                            <form method="POST" action="{{ route('stickers.add') }}">
                                @csrf
                                <input hidden type="number" value="{{ $vehicle->id }}" name="vehicle_id">
                                <div class="row">
                                    <div class="col mb-2">
                                        <label for="number"
                                            class=" col-form-label text-sm-start">{{ __('Sticker Number') }}
                                            <span class="text-danger"> *</span> </label>
                                        <div class="">
                                            <input id="number" type="text" placeholder=""
                                                class="form-control @error('number') is-invalid @enderror" name="number"
                                                value="{{ old('number') }}"required autocomplete="number" autofocus>
                                            @error('number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col mb-1">
                                        <label for="start_date"
                                            class=" col-form-label text-sm-start">{{ __('Start Date') }}</label><span
                                            class="text-danger"> *</span>
                                        <div class="">
                                            <input id="" type="date" placeholder=""
                                                class="form-control start_date @error('start_date') is-invalid @enderror"
                                                name="start_date" value="{{ old('start_date') }}"
                                                autocomplete="start_date" autofocus>
                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col mb-1">
                                        <label for="end_date"
                                            class=" col-form-label text-sm-start">{{ __('End Date') }}</label><span
                                            class="text-danger"> *</span>
                                        <div class="">
                                            <input id="" type="date" placeholder=""
                                                class="form-control end_date @error('end_date') is-invalid @enderror"
                                                name="end_date" value="{{ old('end_date') }}" autocomplete="end_date"
                                                autofocus>
                                            @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <label for="receipt_number"
                                            class=" col-form-label text-sm-start">{{ __('Receipt Number') }}</label><span
                                            class="text-danger"> *</span>
                                        <div class="">
                                            <input id="receipt_number" type="text" placeholder="" required
                                                class="form-control @error('receipt_number') is-invalid @enderror"
                                                name="receipt_number" value="{{ old('receipt_number') }}"
                                                autocomplete="receipt_number" autofocus>
                                            @error('receipt_number')
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
            </div>
            <br>
            <div class="card">
                <div class="card-header  text-center" style="font-size: 20px">
                    Stickers
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3 table table-hover"style="width: 100%">
                            <thead class=" table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Number</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th class="text-center">Validity</th>
                                    <th>Receipt Number</th>
                                    <th>PLN</th>
                                    <th class="text-left">Term</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($stickers as $index => $sticker)
                                    <tr class="{{ $index == 0 ? 'latest-tr' : '' }}">
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>{{ $sticker->number }}</td>
                                        <td>{{ Illuminate\Support\Carbon::parse($sticker->start_date)->format('d M, Y') }}
                                        </td>
                                        <td>{{ Illuminate\Support\Carbon::parse($sticker->end_date)->format('d M, Y') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($sticker->is_valid)
                                                <label for="" class="mx-1 px-1"
                                                    style="background-color:rgba(203, 253, 203, 0.833);color:green">VALID</label>
                                            @else
                                                <label for="" class="mx-1 px-1"
                                                    style="background-color:rgba(251, 190, 190, 0.825);color:red">EXPIRED</label>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $sticker->payment->receipt_number }}
                                        </td>
                                        <td>
                                            {{ $sticker->vehicle->parking->pln }}
                                        </td>
                                        <td class="text-left">
                                            @if ($index == 1)
                                                LATEST
                                            @else
                                                OLD
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-outline-primary mx-1" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#previewStickerModal-{{ $sticker->id }}"
                                                aria-expanded="false" aria-controls="collapseTwo"><i
                                                    class="fa fa-eye"></i>
                                            </a>
                                            <div class="modal  fade" id="previewStickerModal-{{ $sticker->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Preview Sticker
                                                            </h5>
                                                            <button type="button" class="btn btn-danger btn-sm btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            Document
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" class="btn  btn-outline-primary mx-1" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editStickerModal-{{ $sticker->id }}"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                Edit
                                            </a>
                                            <div class="modal modal-md fade" id="editStickerModal-{{ $sticker->id }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Sticker
                                                            </h5>
                                                            <button type="button" class="btn btn-danger btn-sm btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('stickers.edit', $sticker) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="text-start col mb-1">
                                                                    <input hidden type="number"
                                                                        value="{{ $vehicle->id }}" name="vehicle_id">
                                                                        <label for="number"
                                                                            class=" col-form-label text-sm-start">{{ __('Sticker Number') }}</label><span
                                                                            class="text-danger"> *</span>
                                                                        <div class="">
                                                                            <input id="number" type="text"
                                                                                placeholder=""
                                                                                class="form-control @error('number') is-invalid @enderror"
                                                                                name="number"
                                                                                value="{{ old('number', $sticker->number) }}"
                                                                                autocomplete="number" autofocus>
                                                                            @error('number')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-start col mb-1">
                                                                        <label for="start_date"
                                                                            class=" col-form-label text-sm-start">{{ __('Start Date') }}</label><span
                                                                            class="text-danger"> *</span>
                                                                        <div class="">
                                                                            <input id="" type="date"
                                                                                placeholder=""
                                                                                class="form-control start_date @error('start_date') is-invalid @enderror"
                                                                                name="start_date"
                                                                                value="{{ old('start_date', $sticker->start_date) }}"
                                                                                autocomplete="start_date" autofocus>
                                                                            @error('start_date')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="text-start col mb-1">
                                                                        <label for="end_date"
                                                                            class=" col-form-label text-sm-start">{{ __('End Date') }}</label><span
                                                                            class="text-danger"> *</span>
                                                                        <div class="">
                                                                            <input id="end_date" type="date"
                                                                                placeholder=""
                                                                                class="form-control end_date @error('end_date') is-invalid @enderror"
                                                                                name="end_date"
                                                                                value="{{ old('end_date', $sticker->end_date) }}"
                                                                                autocomplete="end_date" autofocus>
                                                                            @error('end_date')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-start col mb-1">
                                                                        <label for="receipt_number"
                                                                            class=" col-form-label text-sm-start">{{ __('Payment Receipt Number') }}</label>
                                                                        <span class="text-danger"> *</span>
                                                                        <div class="">
                                                                            <input id="receipt_number" type="text"
                                                                                placeholder=""
                                                                                class="form-control @error('receipt_number') is-invalid @enderror"
                                                                                name="receipt_number"
                                                                                value="{{ old('receipt_number', $sticker->payment->receipt_number) }}"
                                                                                autocomplete="receipt_number" autofocus>
                                                                            @error('receipt_number')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-1 mt-2">
                                                                    <div class="text-center">
                                                                        <button type="submit"
                                                                            class="btn  btn-outline-primary">
                                                                            {{ __('Submit') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <div class="modal modal-sm fade" id="emailModal-{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Email
                        </h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('send-email') }}">
                            @csrf
                            <input hidden type="text" name="vehicle_id" value="{{ $vehicle->id }}">
                            <div class="text-start mb-1">
                                <label for="subject" class="col-form-label text-sm-start">{{ __('Subject') }}</label>
                                <input id="subject" type="text" placeholder="Subject" name="subject"
                                    class="form-control @error('subject') is-invalid @enderror" subject="subject"
                                    value="{{ old('subject') }}" required autocomplete="subject" autofocus>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
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
                                        {{ __('Send Email') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-sm fade" id="messageModal-{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Message
                        </h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <form method="POST" action="{{ route('vehicles.send_message',) }}">
                            @csrf
                            <input hidden type="text" name="vehicle_id" value="{{ $vehicle->id }}">
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
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-lg fade" id="edit_vehicle_modal-{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Vehicle Info
                        </h5>
                        <button type="button" class="btn btn-danger btn-sm btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('includes.edit_vehicle_modal')
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-lg fade" id="mapModal-{{ $vehicle->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $vehicle->name }} Location
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
            $(".start_date").change(function() {
                var start_date = new Date($(this).val());
                var end_date = new Date(start_date);
                end_date.setFullYear(end_date.getFullYear() + 1);
                end_date.setDate(end_date.getDate() - 1);
                $(".end_date").val(end_date.toISOString().substring(0, 10));
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
@endsection
