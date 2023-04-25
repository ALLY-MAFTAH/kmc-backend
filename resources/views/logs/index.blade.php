@extends('layouts.app')

@section('title')
    Log Activities
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
                                        <small>{{ __(' Log Activities') . ' - ' }}
                                        </small>
                                        <div class="btn btn-icon round"
                                            style="height: 32px;width:32px;cursor: auto;padding: 0;font-size: 15px;line-height:2rem; border-radius:50%;background-color:rgb(207, 227, 242);color:var(--first-color)">
                                            {{ $logs->count() }}
                                        </div>
                                    </span>
                                </h5>
                            </div>
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
                                    <th>#</th>
                                    <th>User Id</th>
                                    <th>Time</th>
                                    <th>User Name</th>
                                    <th>Subject</th>
                                    <th>Ip</th>
                                    <th>URL</th>
                                    <th>Method</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if ($logs->count())
                                    @foreach ($logs as $index => $log)
                                        <tr style="height:2px">
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $log->user_id }}</td>
                                            <td> {{ $log->created_at->format('d M Y \a\t H:i:s') }} </td>
                                            <td>{{ $log->user->name }}</td>
                                            <td>{{ $log->subject }}</td>
                                            <td class="text-warning">{{ $log->ip }}</td>
                                            <td class="text-success">{{ $log->url }}</td>
                                            <td><label
                                                    style="display:inline;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em;background-color:#5bc0de">{{ $log->method }}</label>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

    </div>
@endsection
@section('script')
@endsection
