@extends('layouts.app')

@section('title')
    Payments
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
                                        <small>{{ __('Payments Made For Kinondoni Municipal') . ' - ' }}
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $payments->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div hidden class="col text-right">
                            <a href="#" class="btn  btn-outline-primary collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">

                                <i class="feather icon-plus"></i> Add New Payment

                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="collapseTwo" style="width: 100%;border-width:0px" class="accordion-collapse collapse"
                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="card mb-1 p-2" style="background: var(--form-bg-color)">
                                <form method="POST" action="{{ route('payments.add') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-1">
                                            <label for="name" class=" col-form-label text-sm-start">{{ __('Name') }}
                                                <span class="text-danger"> *</span> </label>
                                            <div class="">
                                                <input id="name" type="text" placeholder="Name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}"required autocomplete="name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col mb-1">
                                            <label for="description"
                                                class=" col-form-label text-sm-start">{{ __('Description') }}</label>
                                            <div class="">
                                                <input id="description" type="text" placeholder="Description"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    name="description" value="{{ old('description') }}"
                                                    autocomplete="description" autofocus>
                                                @error('description')
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
                                    <th>Issued Date</th>
                                    <th>Receipt Number</th>
                                    <th>Sticker Number</th>
                                    <th>Vehicle Reg. Number</th>
                                    <th>Vehicle Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($payments as $index => $payment)
                                    <tr>
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>{{ Illuminate\Support\Carbon::parse($payment->date)->format('d M Y') }}</td>
                                        <td>{{ $payment->receipt_number }}</td>
                                        <td>{{ $payment->sticker->number }}</td>

                                        <td>
                                            @if ($payment->vehicle)
                                                <span onclick="goToVehicle(event)"
                                                    data-id="{{ $payment->vehicle->reg_number }}" style="cursor: pointer"
                                                    class="text-primary">
                                                    {{ $payment->vehicle->reg_number }}</span>
                                            @else
                                                <span class="text-danger">Deleted Vehicle</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment->vehicle->type }}</td>
                                        <td>{{ number_format($payment->amount, 0, '.', ',') }} TZS</td>
                                    </tr>
                                    @php
                                        $total += $payment->amount;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tr>
                                <td colspan="5"></td>
                                <td>
                                    <h5>Total</h5>
                                </td>
                                <td>
                                    <h5>{{ number_format($total, 0, '.', ',') }} TZS </h5>
                                </td>
                            </tr>
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
