@extends('layouts.app')

@section('title')
    Stickers
@endsection

@section('style')
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
                                        <small>{{ __('Stickers') . ' - ' }}
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $stickers->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <form action="{{ route('stickers.index') }}" method="GET" id="filter-form">
                                @csrf
                                <div class="input-group">
                                    <label for="sticker_status" class=" col-form-label">Sticker Status:
                                    </label>
                                    <select name="sticker_status" id="sticker_status" class="form-select  mx-1 form-control"
                                        style="border-radius:0.375rem;" onchange="this.form.submit()">
                                        <option
                                            value='All Stickers'{{ $sticker_status == 'All Stickers' ? 'selected' : '' }}>
                                            All Stickers </option>
                                        <option value='1'{{ $sticker_status == '1' ? 'selected' : '' }}>
                                            Valid Stickers </option>
                                        <option value='0'{{ $sticker_status == '0' ? 'selected' : '' }}>
                                            Expired Stickers </option>

                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3 table table-hover"style="width: 100%">
                            <thead class=" table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>Number</th>
                                    <th>Reg. Number</th>
                                    <th>PLN</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th class="text-center">Validity</th>
                                    <th>Receipt Number</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stickers as $index => $sticker)
                                    <tr>
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td class="text-start">{{ $sticker->number }}</td>
                                        <td class="text-start">
                                            @if ($sticker->vehicle)
                                                <span onclick="goToVehicle(event)" data-id="{{ $sticker->vehicle->reg_number }}"
                                                    style="cursor: pointer" class="text-primary">
                                                    {{ $sticker->vehicle->reg_number }}</span>
                                            @else
                                                <span class="text-danger">Deleted Vehicle</span>
                                                @endif
                                            </td>
                                            <td class="text-start">{{ $sticker->vehicle->parking->pln }}</td>
                                        <td class="text-start">
                                            {{ Illuminate\Support\Carbon::parse($sticker->start_date)->format('d M Y') }}
                                        </td>
                                        <td class="text-start">
                                            {{ Illuminate\Support\Carbon::parse($sticker->end_date)->format('d M Y') }}
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

                                                            <img src="{{asset('images/sticker.jpg')}}" width="80%" height="80%" alt="">
                                                            <br>

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

    </div>
@endsection
@section('scripts')
    <script>
        function goToVehicle(event) {
            var reg_number = event.target.dataset.id;
            window.location.href = '/vehicle?reg_number=' + reg_number;
        }
    </script>
@endsection
