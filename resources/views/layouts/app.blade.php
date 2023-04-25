<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') | {{ config('app.name', 'Smart Kinondoni') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="../assets/css/demo/style.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- DATA TABLE --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.bootstrap5.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {

            font-family: "Roboto", sans-serif;
        }
    </style>
    @yield('style')
</head>

<body>
    <script src="../assets/js/preloader.js"></script>
    @include('sweetalert::alert')

    <div class="main-banner">

        <div class="body-wrapper">

            <aside class=" mdc-drawer mdc-drawer--dismissible mdc-drawer--open side-menyu">
                <div class="mdc-drawer__header">
                    <a href="{{ route('home') }}" class="brand-logo" style="text-decoration: none">
                        <img src="{{ asset('images/logo.png') }}" height="30px" alt="logo"><span
                            class="app-name">My System Name</span>
                    </a>
                </div>
                <div class="mdc-drawer__content">
                    <div class="user-info">
                        <p class="name">{{ Auth::user()->name }}</p>
                        <p class="email">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="mdc-list-group">
                        <nav class="mdc-list mdc-drawer-menu">
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                    href="{{ route('home') }} ">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">home</i>
                                    Dashboard
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-expansion-panel-link {{ request()->routeIs('provinces.show') || request()->routeIs('wards.show') || request()->routeIs('sub_wards.show') || request()->routeIs('streets.show') ? 'expanded' : '' }}"
                                    href="#" data-toggle="expansionPanel" data-target="divisions">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">dashboard</i>
                                    Divisions
                                    <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                                </a>
                                <div class="mdc-expansion-panel {{ request()->routeIs('provinces.show') || request()->routeIs('wards.show') || request()->routeIs('sub_wards.show') || request()->routeIs('streets.show') ? 'expanded' : '' }}"
                                    id="divisions"
                                    style=" {{ request()->routeIs('provinces.show') || request()->routeIs('wards.show') || request()->routeIs('sub_wards.show') || request()->routeIs('streets.show') ? 'display: block' : 'display: none' }}">
                                    <nav class="mdc-list mdc-drawer-submenu">
                                        <div class="mdc-list-item mdc-drawer-item">
                                            <a class="mdc-drawer-link {{ request()->routeIs('provinces.show') ? 'active' : '' }}"
                                                href="{{ route('provinces.index') }}">
                                                Provinces
                                            </a>
                                        </div>
                                        <div class="mdc-list-item mdc-drawer-item">
                                            <a class="mdc-drawer-link  {{ request()->routeIs('wards.show') ? 'active' : '' }}"
                                                href="{{ route('wards.index') }}">
                                                Wards
                                            </a>
                                        </div>
                                        <div class="mdc-list-item mdc-drawer-item">
                                            <a class="mdc-drawer-link  {{ request()->routeIs('sub_wards.show') ? 'active' : '' }}"
                                                href="{{ route('sub_wards.index') }}">
                                                Sub-Wards
                                            </a>
                                        </div>
                                        <div class="mdc-list-item mdc-drawer-item">
                                            <a class="mdc-drawer-link  {{ request()->routeIs('streets.show') ? 'active' : '' }}"
                                                href="{{ route('streets.index') }}">
                                                Streets
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->routeIs('owners.show') || request()->routeIs('owners.show_add_form') ? 'active' : '' }}"
                                    href="{{ route('owners.index') }}">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">person</i>
                                    Owners
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->routeIs('drivers.show') || request()->routeIs('drivers.show_add_form') ? 'active' : '' }}"
                                    href="{{ route('drivers.index') }}">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">people_outline</i>
                                    Drivers
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->routeIs('vehicles.show') || request()->routeIs('vehicles.show_add_form') ? 'active' : '' }}"
                                    href="{{ route('vehicles.index') }}">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">motorcycle</i>
                                    Vehicles
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->routeIs('parkings.show') ? 'active' : '' }}"
                                    href="{{ route('parkings.index') }}">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">local_parking</i>
                                    Parkings
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link {{ request()->routeIs('stickers.show') ? 'active' : '' }}"
                                    href="{{ route('stickers.index') }}">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">receipt</i>
                                    Stickers
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="{{ route('payments.index') }}">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">attach_money</i>
                                    Payments
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-drawer-link" href="{{ route('reports.index') }}">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">insert_drive_file</i>
                                    Reports
                                </a>
                            </div>
                            <div class="mdc-list-item mdc-drawer-item">
                                <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel"
                                    data-target="users_roles">
                                    <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                        aria-hidden="true">people</i>
                                    Users & Roles
                                    <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                                </a>
                                <div class="mdc-expansion-panel" id="users_roles">
                                    <nav class="mdc-list mdc-drawer-submenu">
                                        <div class="mdc-list-item mdc-drawer-item">
                                            <a class="mdc-drawer-link" href="{{ route('users.index') }}">
                                                Users
                                            </a>
                                        </div>
                                        <div class="mdc-list-item mdc-drawer-item">
                                            <a class="mdc-drawer-link" href="{{ route('roles.index') }}">
                                                Roles
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <br>
                    <div class="profile-actions">
                        <span class="text-center text-sm-left d-block d-sm-inline-block tx-14">Copyright ©
                            <a href="https://www.kinondonimc.go.tz" style="text-decoration: none"
                                target="_blank">www.kinondonimc.go.tz
                            </a>&nbsp; {{ date('Y') }}</span>
                    </div>

                </div>
            </aside>
            <!-- partial -->
            <!-- partial:partials/_navbar.html -->
            <div class=" main-wrapper mdc-drawer-app-content">
                <div class="row">
                    <div class="col-4">
                        <img src="../images/logo.png" height="65px" alt="">
                    </div>
                    <div class="col-8">
                        <div class="banner-img"> </div>
                    </div>
                    <div class="brand-name"> {{ 'Smart Kinondoni' }} </div>
                </div>
                <div class="banner-2">
                    <div class="offset-6">
                        <marquee behavior="scroll" onmouseover="this.stop();" onmouseout="this.start();">
                            <a style="text-decoration: none;color:rgb(10, 32, 10)" href="{{ route('home') }}">
                                <img src="../images/new.png" width="40" alt="New" />
                                Mwongozo Wa Utekelezaji Wa Mpango Wa Ruzuku Ya Mbolea Kwa Msimu Wa 2022/2023
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <img src="../images/new.png" width="40" alt="New" />
                                Mwongozo Wa Utekelezaji Wa Mpango Wa Ruzuku Ya Mbolea Kwa Msimu Wa 2022/2023
                            </a>
                        </marquee>
                    </div>

                </div>
                <header class="mdc-top-app-bar">
                    <div class="mdc-top-app-bar__row">
                        <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                            <button
                                class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
                            <span class="mdc-top-app-bar__title">Search Vehicle</span>
                            <form action="{{ route('vehicles.show') }}" method="get">@csrf
                                <div
                                    class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon search-text-field d-none d-md-flex">
                                    <i class="material-icons mdc-text-field__icon">search</i>
                                    <input class="mdc-text-field__input" id="text-field-hero-input"
                                        list="reg_numbers" autocomplete="off" name="reg_number">
                                    <datalist id="reg_numbers">
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->reg_number }}">
                                        @endforeach
                                    </datalist>
                                    <div class="mdc-notched-outline">
                                        <div class="mdc-notched-outline__leading"></div>
                                        <div class="mdc-notched-outline__notch">
                                            <label for="text-field-hero-input" class="mdc-floating-label">Registration
                                                Number</label>
                                        </div>
                                        <div class="mdc-notched-outline__trailing"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div
                            class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end mdc-top-app-bar__section-right">
                            <div class="menu-button-container menu-profile d-none d-md-block">
                                <button class="mdc-button mdc-menu-button">
                                    <span class="d-flex align-items-center">
                                        <span class="figure">
                                            <img src="../images/logo.png" alt="user" class="user">
                                        </span>
                                        <span class="user-name">{{ Auth::user()->name }}</span>
                                    </span>
                                </button>
                                <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                                    <ul class="mdc-list" role="menu" aria-hidden="true"
                                        aria-orientation="vertical">
                                        <li class="mdc-list-item" role="menuitem">
                                            <div class="item-thumbnail item-thumbnail-icon-only">
                                                <i class="mdi mdi-account-edit-outline text-primary"></i>
                                            </div>
                                            <div
                                                class="item-content d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="item-subject font-weight-normal">Change Password</h6>
                                            </div>
                                        </li>
                                        <a href="#"
                                            onclick="event.preventDefault();if(confirm('Are you sure want to logout ?'))
            document.getElementById('logout-form').submit();"
                                            style="text-decoration:none">

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                            <li class="mdc-list-item" role="menuitem">
                                                <div class="item-thumbnail item-thumbnail-icon-only">
                                                    <i class="mdi mdi-settings-outline text-primary"></i>
                                                </div>
                                                <div
                                                    class="item-content d-flex align-items-start flex-column justify-content-center">
                                                    <h6 class="item-subject font-weight-normal">Logout</h6>
                                                </div>
                                            </li>
                                        </a>
                                    </ul>
                                </div>
                            </div>
                            <div class="divider d-none d-md-block"></div>
                            <div class="menu-button-container d-none d-md-block">
                                <button class="mdc-button mdc-menu-button">
                                    <i class="mdi mdi-settings"></i>
                                </button>
                                <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                                    <ul class="mdc-list" role="menu" aria-hidden="true"
                                        aria-orientation="vertical">
                                        <a href="#" style="text-decoration:none">
                                            <li class="mdc-list-item" role="menuitem">
                                                <div class="item-thumbnail item-thumbnail-icon-only">
                                                    <i class="mdi mdi-alert-circle-outline text-primary"></i>
                                                </div>
                                                <div
                                                    class="item-content d-flex align-items-start flex-column justify-content-center">
                                                    <h6 class="item-subject font-weight-normal">Settings</h6>
                                                </div>
                                            </li>
                                        </a>
                                        <a href="{{ route('logs.index') }}" style="text-decoration:none">
                                            <li class="mdc-list-item" role="menuitem">
                                                <div class="item-thumbnail item-thumbnail-icon-only">
                                                    <i class="mdi mdi-progress-download text-primary"></i>
                                                </div>
                                                <div
                                                    class="item-content d-flex align-items-start flex-column justify-content-center">
                                                    <h6 class="item-subject font-weight-normal">Avtivity Logs</h6>
                                                </div>
                                            </li>
                                        </a>

                                    </ul>
                                </div>
                            </div>
                            <div class="menu-button-container">
                                <button class="mdc-button mdc-menu-button">
                                    <i class="mdi mdi-bell"></i>
                                    <span class="count-indicator">
                                        <span class="count">3</span>
                                    </span>
                                </button>
                                <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                                    <h6 class="title"> <i class="mdi mdi-bell-outline mr-2 tx-16"></i> Notifications
                                    </h6>
                                    <ul class="mdc-list" role="menu" aria-hidden="true"
                                        aria-orientation="vertical">
                                        <li class="mdc-list-item" role="menuitem">
                                            <div class="item-thumbnail item-thumbnail-icon">
                                                <i class="mdi mdi-email-outline"></i>
                                            </div>
                                            <div
                                                class="item-content d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="item-subject font-weight-normal">You received a new message
                                                </h6>
                                                <small class="text-muted"> 6 min ago </small>
                                            </div>
                                        </li>
                                        <li class="mdc-list-item" role="menuitem">
                                            <div class="item-thumbnail item-thumbnail-icon">
                                                <i class="mdi mdi-account-outline"></i>
                                            </div>
                                            <div
                                                class="item-content d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="item-subject font-weight-normal">New user registered</h6>
                                                <small class="text-muted"> 15 min ago </small>
                                            </div>
                                        </li>
                                        <li class="mdc-list-item" role="menuitem">
                                            <div class="item-thumbnail item-thumbnail-icon">
                                                <i class="mdi mdi-alert-circle-outline"></i>
                                            </div>
                                            <div
                                                class="item-content d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="item-subject font-weight-normal">System Alert</h6>
                                                <small class="text-muted"> 2 days ago </small>
                                            </div>
                                        </li>
                                        <li class="mdc-list-item" role="menuitem">
                                            <div class="item-thumbnail item-thumbnail-icon">
                                                <i class="mdi mdi-update"></i>
                                            </div>
                                            <div
                                                class="item-content d-flex align-items-start flex-column justify-content-center">
                                                <h6 class="item-subject font-weight-normal">You have a new update</h6>
                                                <small class="text-muted"> 3 days ago </small>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </header>
                <!-- partial -->
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://use.fontawesome.com/704fe45b80.js"></script>

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/vendors/chartjs/Chart.min.js"></script>
    <script src="../assets/js/material.js"></script>
    <script src="../assets/js/misc.js"></script>


    {{-- DATA TABLE --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.colVis.min.js"></script>

    @yield('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('submit', 'form', function() {
                $('button').attr('disabled', 'disabled');

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#data-tebo1').DataTable({
                dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthChange: true,
                columnDefs: [{
                    visible: true,
                    targets: '_all'
                }, ],
                buttons: [{
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        },
                        messageTop: 'DATAAAAAAAAAA'

                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        },
                        margin: [20, 20, 20, 20],
                        padding: [20, 20, 20, 20],
                        customize: function(doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                                .length + 1).join('*').split('');
                            doc.content[1].table.widths[0] = 'auto';
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                ]
            });
            table.buttons().container()
                .appendTo('#data-tebo1_wrapper .col-md-6:eq(0)');

        });
    </script>
</body>

</html>
