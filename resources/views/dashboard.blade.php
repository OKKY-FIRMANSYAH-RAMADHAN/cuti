@extends('layout.template')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endsection

@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <main id="main-container">
        <!-- Hero -->
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        {{ $title }}
                    </h1>
                    <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                        Welcome <a class="fw-semibold">{{ session()->get('nama') }}</a>, everything looks great.
                    </h2>
                </div>
                <div class="mt-3 mt-md-0 ms-md-3 space-x-1">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-sm btn-alt-secondary space-x-1"
                            id="dropdown-analytics-overview" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-fw fa-calendar-alt opacity-50"></i>
                            <span>{{ $selectValue }}</span>
                            <i class="fa fa-fw fa-angle-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-analytics-overview">
                            <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                href="?bulan={{ Carbon::now()->month }}&tahun={{ Carbon::now()->year }}"><span>Bulan
                                    Ini</span> {!! $selectValue == 'Bulan Ini' ? "<i class='fa fa-check'></i>" : '' !!} </a>
                            <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                href="?bulan={{ Carbon::now()->month - 1 }}&tahun={{ Carbon::now()->year }}"><span>Bulan
                                    Kemarin</span> {!! $selectValue == 'Bulan Kemarin' ? "<i class='fa fa-check'></i>" : '' !!}</a>
                            <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                href="?bulanmulai={{ Carbon::now()->month - 2 }}&bulanakhir={{ Carbon::now()->month }}"><span>3
                                    Bulan Terakhir</span> {!! $selectValue == '3 Bulan Terakhir' ? "<i class='fa fa-check'></i>" : '' !!}</a>
                            <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                href="?bulanmulai={{ Carbon::now()->month - 5 }}&bulanakhir={{ Carbon::now()->month }}"><span>6
                                    Bulan Terakhir</span> {!! $selectValue == '6 Bulan Terakhir' ? "<i class='fa fa-check'></i>" : '' !!}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                href="?tahun={{ Carbon::now()->year }}"><span>Tahun Ini</span> {!! $selectValue == 'Tahun Ini' ? "<i class='fa fa-check'></i>" : '' !!}</a>
                            <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                href="?tahun={{ Carbon::now()->year - 1 }}"><span>Tahun Kemarin</span>
                                {!! $selectValue == 'Tahun Kemarin' ? "<i class='fa fa-check'></i>" : '' !!}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                href="/">
                                <span>Sepanjang Masa</span>
                                {!! $selectValue == 'Sepanjang Masa' ? "<i class='fa fa-check'></i>" : '' !!}
                            </a>
                        </div>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn btn-sm btn-alt-secondary space-x-1"
                            id="dropdown-analytics-overview" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-fw fa-list opacity-50"></i>
                            <span>{{ $selectDivisi }}</span>
                            <i class="fa fa-fw fa-angle-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-kategori">
                            <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                href="#" onclick="updateUrl('divisi', 'all')">SEMUA DIVISI</a>
                            @foreach ($divisi as $dvs)
                                <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                                    href="#"
                                    onclick="updateUrl('divisi', '{{ $dvs->id_divisi }}')">{{ $dvs->nama_divisi }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Overview -->
            <div class="row items-push">
                <div class="col-sm-6 col-xxl-3">
                    <!-- Pending Orders -->
                    <div class="block block-rounded d-flex flex-column mb-0" style="height: 130px;">
                        <div
                            class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt class="fs-3 fw-bold">{{ $totalC }}</dt>
                                <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Total Cuti</dd>
                            </dl>
                            <div class="item item-rounded-lg bg-body-light">
                                <i class="fab fa-cuttlefish fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <!-- END Pending Orders -->
                </div>
                <div class="col-sm-6 col-xxl-3">
                    <!-- New Customers -->
                    <div class="block block-rounded d-flex flex-column mb-0" style="height: 130px;">
                        <div
                            class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt class="fs-3 fw-bold">{{ $totalSD }}</dt>
                                <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Total Surat Dokter</dd>
                            </dl>
                            <div class="item item-rounded-lg bg-body-light">
                                <i class="far fa-envelope fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <!-- END New Customers -->
                </div>
                <div class="col-sm-6 col-xxl-3">
                    <!-- Messages -->
                    <div class="block block-rounded d-flex flex-column mb-0" style="height: 130px;">
                        <div
                            class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt class="fs-3 fw-bold">{{ $totalDR }}</dt>
                                <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Total Dirumahkan</dd>
                            </dl>
                            <div class="item item-rounded-lg bg-body-light">
                                <i class="fas fa-home fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <!-- END Messages -->
                </div>
                <div class="col-sm-6 col-xxl-3">
                    <!-- Conversion Rate -->
                    <div class="block block-rounded d-flex flex-column mb-0" style="height: 130px;">
                        <div
                            class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt class="fs-3 fw-bold">{{ $totalDIS }}</dt>
                                <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Total 1/2 Hari</dd>
                            </dl>
                            <div class="item item-rounded-lg bg-body-light">
                                <i class="fas fa-star-half-alt fs-3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <!-- END Conversion Rate-->
                </div>
            </div>
            <!-- END Overview -->

            <!-- Statistics -->
            <div class="row">
                <div class="col-xl-8 col-xxl-9 d-flex flex-column">
                    <!-- Earnings Summary -->
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Grafik Data</h3>
                        </div>
                        <div class="block-content block-content-full flex-grow-1 d-flex align-items-center">
                            <canvas id="js-chartjs-bars"></canvas>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="row items-push text-center w-100">
                                <div class="col-6 col-sm-2">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold d-inline-flex align-items-center space-x-2">
                                            <span>{{ $percentSD }}%</span>
                                        </dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">Surat Dokter</dd>
                                    </dl>
                                </div>
                                <div class="col-6 col-sm-2">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold d-inline-flex align-items-center space-x-2">
                                            <span>{{ $percentS }}%</span>
                                        </dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">Sakit</dd>
                                    </dl>
                                </div>
                                <div class="col-6 col-sm-2">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold d-inline-flex align-items-center space-x-2">
                                            <span>{{ $percentI }}%</span>
                                        </dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">Ijin</dd>
                                    </dl>
                                </div>
                                <div class="col-6 col-sm-2">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold d-inline-flex align-items-center space-x-2">
                                            <span>{{ $percentA }}%</span>
                                        </dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">Alpa</dd>
                                    </dl>
                                </div>
                                <div class="col-6 col-sm-2">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold d-inline-flex align-items-center space-x-2">
                                            <span>{{ $percentDIS }}%</span>
                                        </dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">DIS</dd>
                                    </dl>
                                </div>
                                <div class="col-6 col-sm-2">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold d-inline-flex align-items-center space-x-2">
                                            <span>{{ $percentA + $percentSD + $percentS + $percentI + $percentDIS }}%</span>
                                        </dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">Total</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Earnings Summary -->
                </div>
                <div class="col-xl-4 col-xxl-3 d-flex flex-column">
                    <div class="row items-push flex-grow-1">
                        <div class="col-md-6 col-xl-12">
                            <div class="block block-rounded d-flex flex-column mb-0" style="height: 130px;">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center mb-0">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold">{{ $totalA }}</dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">Total Alpa</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fab fa-amilia fs-3 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-12">
                            <div class="block block-rounded d-flex flex-column mb-0" style="height: 130px;">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center mb-0">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold">{{ $totalI }}</dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">Total Ijin</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fas fa-info fs-3 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="block block-rounded d-flex flex-column mb-0" style="height: 130px;">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center mb-0">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold">{{ $totalS }}</dt>
                                        <dd class="fs-sm fw-medium text-muted mb-0">Total Sakit</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fas fa-tired fs-3 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Last 2 Weeks -->
                </div>
            </div>
            <!-- END Statistics -->

            <!-- Recent Orders -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Karyawan Sering Tidak Masuk</h3>
                </div>
                <div class="block-content block-content-full">
                    <!-- Recent Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons-custom">
                            <thead>
                                <tr>
                                    <th>Nama Karyawan</th>
                                    <th class="d-xl-table-cell">Bagian</th>
                                    <th class="text-center">Total Tidak Masuk</th>
                                    <th class="d-sm-table-cell text-center">Sakit</th>
                                    <th class="d-sm-table-cell text-center">Ijin</th>
                                    <th class="d-sm-table-cell text-center">Alpa</th>
                                </tr>
                            </thead>
                            <tbody class="fs-sm">
                                @foreach ($karyawan as $krywn)
                                    <tr>
                                        <td>
                                            <a href="{{ route('karyawan.detail', ['id' => $krywn->id_karyawan]) }}"
                                                class="fw-semibold">{{ $krywn->nama_karyawan }}</a>
                                        </td>
                                        <td class="d-xl-table-cell">
                                            <a class="fw-semibold">{{ $krywn->nama_bagian }}</a>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="fw-bold d-inline-block py-1 px-3 rounded-pill bg-info-light text-info">{{ $krywn->jumlah_cuti_total }}</span>
                                        </td>
                                        <td class="d-sm-table-cell text-center">
                                            {{ $krywn->sakit }}
                                        </td>
                                        <td class="d-sm-table-cell text-center">{{ $krywn->ijin }}</td>
                                        <td class="d-sm-table-cell text-center">
                                            {{ $krywn->alpa }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- END Recent Orders Table -->
                </div>
            </div>
            <!-- END Recent Orders -->
        </div>
        <!-- END Page Content -->
    </main>
@endsection
@section('javascript')
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chart.js/chart.umd.js') }}"></script>>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Chart.defaults.color = "#818d96";
            Chart.defaults.font.weight = "600";
            Chart.defaults.scale.grid.color = "rgba(0, 0, 0, .05)";
            Chart.defaults.scale.grid.zeroLineColor = "rgba(0, 0, 0, .1)";
            Chart.defaults.scale.beginAtZero = true;
            Chart.defaults.elements.line.borderWidth = 2;
            Chart.defaults.elements.point.radius = 4;
            Chart.defaults.elements.point.hoverRadius = 6;
            Chart.defaults.plugins.tooltip.radius = 3;
            Chart.defaults.plugins.legend.labels.boxWidth = 15;

            let t, a, e, r, o, n, i, s, l = document.getElementById("js-chartjs-lines"),
                d = document.getElementById("js-chartjs-bars");

            let labels = {!! json_encode($tanggalBulanIni) !!};
            let formattedLabels = labels.map(label => `${label}`);

            i = {
                labels: formattedLabels,
                datasets: [{
                    label: "Surat Dokter",
                    fill: true,
                    backgroundColor: "mediumblue",
                    data: {{ json_encode($dataBarSD) }}
                }, {
                    label: "Sakit",
                    fill: true,
                    backgroundColor: "deepskyblue",
                    data: {{ json_encode($dataBarS) }}
                }, {
                    label: "Ijin",
                    fill: true,
                    backgroundColor: "grey",
                    data: {{ json_encode($dataBarI) }}
                }, {
                    label: "Alpa",
                    fill: true,
                    backgroundColor: "red",
                    data: {{ json_encode($dataBarA) }}
                }, {
                    label: "DIS",
                    fill: true,
                    backgroundColor: "green",
                    data: {{ json_encode($dataBarDIS) }}
                }]
            };

            if (d) {
                a = new Chart(d, {
                    type: "bar",
                    data: i,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                ticks: {
                                    callback: function(value) {
                                        return Number(value).toFixed(0);
                                    },
                                    stepSize: 1
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>

    <script>
        function updateUrl(key, value) {
            const url = new URL(window.location.href);

            if (value === 'all') {
                url.searchParams.delete(key);
            } else {
                url.searchParams.set(key, encodeURIComponent(value));
            }

            window.location.href = url.toString();
        }
    </script>
@endsection
