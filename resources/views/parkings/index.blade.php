@extends('layouts.app')

@section('title')
    Parking
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
                                        <small>{{ __('Parking Under Kinondoni Municipal') . ' - ' }}
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $parkings->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="col">
                            <form action="{{ route('parkings.index') }}" method="GET" id="filter-form">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <select name="sticker_status" id="sticker_status"
                                                class="form-select  mx-1 form-control" style="border-radius:0.375rem;"
                                                onchange="this.form.submit()">


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <select name="type_id" id="type_id" class="form-select  mx-1 form-control"
                                                style="border-radius:0.375rem;" onchange="this.form.submit()">
                                                {{-- <option value='All Types'{{ $type_id == 'All Types' ? 'selected' : '' }}>
                                                    All Types </option>

                                                    <option
                                                        value='{{ "Pikipiki" }}'{{ $type->id == $type_id ? 'selected' : '' }}>
                                                        {{ $type->name }} </option> --}}

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col text-right">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive-lg">
                        <table id="data-tebo1"
                            class="dt-responsive nowrap shadow rounded-3  table table-hover"style="width: 100%">

                            <thead class="table-head">
                                <tr>
                                    <th class="text-center" style="max-width: 20px">#</th>
                                    <th>PLN</th>
                                    <th>Name</th>
                                    <th>Capacity</th>
                                    <th>Active Vehicles</th>
                                    <th>Leader's Full Name</th>
                                    <th>Leader's Mobile</th>
                                    <th>Location</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parkings as $index => $parking)
                                    <tr ondblclick="goToParkingTr(event)" data-id="{{ $parking->id }}"
                                        style="cursor: pointer">
                                        <td class="text-center" style="max-width: 20px">{{ ++$index }}</td>
                                        <td>{{ $parking->pln }}</td>
                                        <td>{{ Illuminate\Support\Str::upper($parking->name) }}</td>
                                        <td class="text-center">{{ $parking->capacity }}</td>
                                        <td class="text-center">{{ $parking->no_of_vehicles }}</td>
                                        <td>{{ $parking->leader_name }}</td>
                                        <td>{{ $parking->leader_mobile }}</td>
                                        <td class="text-center">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#locationModal-{{ $parking->id }}"><i
                                                    class="material-icons" style="">location_on</i></a>

                                            <div class="modal modal-lg fade" id="locationModal-{{ $parking->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Parking Location
                                                            </h5>
                                                            <button type="button" class="btn btn-danger btn-sm btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Province</th>
                                                                            <th>Ward</th>
                                                                            <th>Sub-Ward</th>
                                                                            <th>Street</th>
                                                                            <th>Address Name</th>
                                                                            <th>Latitude</th>
                                                                            <th>Longitude</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>{{ $parking->street->subWard->ward->province->name }}</td>
                                                                            <td>{{ $parking->street->subWard->ward->name }}</td>
                                                                            <td>{{ $parking->street->subWard->name }}</td>
                                                                            <td>{{ $parking->street->name }}</td>
                                                                            <td>{{ $parking->location->location_name }}</td>
                                                                            <td>{{ $parking->location->latitude }}</td>
                                                                            <td>{{ $parking->location->longitude }} </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div>
                                                                    <iframe
                                                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126792.51368090636!2d38.9826250076294!3d-6.737363608470637!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c5b0dcd3c8ea3%3A0x55e6f7d7fd250745!2sTegeta%20A%20Kahama%20street!5e0!3m2!1sen!2stz!4v1675687860167!5m2!1sen!2stz"
                                                                    width="760" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class=" text-center">

                                            <a href="{{route('parkings.show',$parking->id)}}"
                                                class="btn btn-outline-info mx-2">View</a>
                                            <a href="#" class="btn  btn-outline-danger mx-2"
                                                onclick="if(confirm('Are you sure want to delete {{ $parking->name }}?')) document.getElementById('delete-parking-{{ $parking->id }}').submit()">
                                                Delete
                                            </a>
                                            <form id="delete-parking-{{ $parking->id }}" method="post"
                                                action="{{ route('parkings.delete', $parking) }}">
                                                @csrf
                                                @method('delete')
                                            </form>
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
        function goToParkingTr(event) {
            var id = event.target.parentNode.dataset.id;
            window.location.href = '/parking/' + id;
        }

        function goToParkingBtn(event) {
            var tin = event.target.dataset.id;
            window.location.href = '/parking?tin=' + tin;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('a i.material-icons').click(function() {
                var tin = $(this).closest('tr').data('id');
                $('#tin_input_' + tin).toggle();
                $('#tin_value_' + tin).toggle();
            });
        });
    </script>
@endsection
