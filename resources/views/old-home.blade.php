@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div
                        class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                        <div class="mdc-card info-card info-card--success">
                            <div class="card-inner">
                                <h5 class="card-title">Business Firms</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">{{ $totalBusinessFirms }}</h5>
                                <p class="tx-12 text-muted">{{ $newThisMonth }} new this month</p>
                                <a href="{{ route('businesses.index') }}" class="">
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">business</i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div
                        class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                        <div class="mdc-card info-card info-card--danger">
                            <div class="card-inner">
                                <h5 class="card-title">Annual Revenue</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">
                                    {{ number_format($annualRevenue, 0, '.', ',') }} TZS</h5>
                                <p class="tx-12 text-muted">{{ $reachedTargetPercent }}% target reached</p>
                                <a href="{{ route('payments.index') }}" class="">
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">attach_money</i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div
                        class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                        <div class="mdc-card info-card info-card--primary">
                            <div class="card-inner">
                                <h5 class="card-title">Expired Licences</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">{{ count($expiredLicences) }}</h5>
                                <p class="tx-12 text-muted">{{ $expiredLicencesPercent }}% of all licences</p>
                                <a href="{{ route('licences.index') }}" class="">
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">trending_up</i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div
                        class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                        <div class="mdc-card info-card info-card--warning">
                            <div class="card-inner">
                                <h5 class="card-title">Leading Business Type</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">{{ $leadingBusinessType }}</h5>
                                <p class="tx-12 text-muted">{{ number_format($leadingBusinessTypeAmount, 0, '.', ',') }}
                                    TZS
                                    of total revenue</p>
                                <a href="{{ route('payments.index') }}" class="">
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">credit_card</i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">Revenue by location</h4>
                                <div>
                                    <i class="material-icons refresh-icon">refresh</i>
                                    <i class="material-icons options-icon ml-2">more_vert</i>
                                </div>
                            </div>
                            <div class="d-block d-sm-flex justify-content-between align-items-center">
                                <h5 class="card-sub-title mb-2 mb-sm-0">Revenue performance ranks based on wards</h5>
                                <div class="menu-button-container">
                                    <button
                                        class="mdc-button mdc-menu-button mdc-button--raised button-box-shadow tx-12 text-dark bg-white font-weight-light">
                                        Last Month
                                        <i class="material-icons">arrow_drop_down</i>
                                    </button>
                                    <div class="mdc-menu mdc-menu-surface" tabindex="-1">
                                        <ul class="mdc-list" role="menu" aria-hidden="true" aria-orientation="vertical">
                                            <li class="mdc-list-item" role="menuitem">
                                                <h6 class="item-subject font-weight-normal">Back</h6>
                                            </li>
                                            <li class="mdc-list-item" role="menuitem">
                                                <h6 class="item-subject font-weight-normal">Forward</h6>
                                            </li>
                                            <li class="mdc-list-item" role="menuitem">
                                                <h6 class="item-subject font-weight-normal">Reload</h6>
                                            </li>
                                            <li class="mdc-list-divider"></li>
                                            <li class="mdc-list-item" role="menuitem">
                                                <h6 class="item-subject font-weight-normal">Save As..</h6>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mdc-layout-grid__inner mt-2">
                                <div
                                    class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">
                                    <div class="table-responsive">
                                        <table class="table dashboard-table">
                                            <tbody>
                                                @foreach ($topFiveWards as $ward)
                                                    @php
                                                        $percentage = round(($ward->total_amount / $annualRevenue) * 100, 2);
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <span class="flag-icon-container"><i
                                                                    class="flag-icon flag-icon-tz mr-2"></i></span>{{ $ward->name }}
                                                        </td>
                                                        <td>{{ number_format($ward->total_amount) }} TZS</td>
                                                        <td class=" font-weight-medium"> {{ $percentage }}% </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div
                                    class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">
                                    <div id="resvenue-map" class="revenue-world-map">
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3177.7295065191934!2d39.22825101477226!3d-6.7887593950930825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4ea59c35c1bd%3A0xb0aae602b2243446!2sKinondoni%20Municipal%20Council!5e1!3m2!1sen!2stz!4v1673762728195!5m2!1sen!2stz"
                                            width="100%" height="200px" style="border:0;" allowfullscreen=""
                                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" py-2">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                            <div class="mdc-card">
                                <h6 class="card-title">Total revenue by years (5 years)</h6>
                                <canvas id="areaChart"></canvas>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                            <div class="mdc-card">
                                <h6 class="card-title">Total revenue based on business type.</h6>
                                <canvas id="doughnutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
@endsection
@section('scripts')
    <script src="../../../assets/vendors/chartjs/Chart.min.js"></script>
    <script src="../../../assets/js/chartjs.js"></script>
    <script>
        var doughnutPieData = {
            datasets: [{
                data: <?php echo json_encode($amounts); ?>,
                backgroundColor: [
                    'rgba(255, 66, 15, 0.8)',
                    'rgba(0, 187, 221, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(0, 182, 122, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 66, 15,1)',
                    'rgba(0, 187, 221, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(0, 182, 122, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
            }],

            labels: <?php echo json_encode($labels); ?>
        };
        var doughnutPieOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            }
        };
    </script>

    <script>
        var areaData = {
            labels: {!! json_encode(array_keys($yearlyPayments)) !!},
            datasets: [{
                label: 'Revenue Amount (  TZS)',
                data: {!! json_encode(array_values($yearlyPayments)) !!},
                backgroundColor: [
                    'rgba(0, 187, 221, 0.4)',
                    'rgba(255, 193, 7, 0.4)',
                    'rgba(0, 182, 122, 0.4)',
                    'rgba(153, 102, 255, 0.4)',
                    'rgba(255, 159, 64, 0.4)'
                ],
                borderColor: [
                    'rgba(0, 187, 221, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(0, 182, 122, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                fill: true, // 3: no fill
            }]
        };

        var areaOptions = {
            plugins: {
                filler: {
                    propagate: true
                }
            }
        }
    </script>
@endsection
