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
                    <h1 class="h3 fw-bold mb-1 no-print">
                        {{ $title }}
                    </h1>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Recent Orders -->
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <!-- Recent Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-riwayat">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Bagian</th>
                                    <th>Divisi</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="fs-sm">
                                @foreach ($riwayat as $rwyt)
                                    <tr>
                                        <td class="text-center fs-sm">{{ $loop->iteration }}</td>
                                        <td>{{ $rwyt->karyawan->nama_karyawan }}</td>
                                        <td>{{ $rwyt->karyawan->bagian->nama_bagian }}</td>
                                        <td>{{ $rwyt->karyawan->divisi->nama_divisi }}</td>
                                        <td>{{ Carbon::parse($rwyt->tanggal)->locale('id')->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="fw-bold text-uppercase text-center">
                                            {{ $rwyt->keterangan === 'SD' ? 'Sakit (Surat Dokter)' : ($rwyt->keterangan === 'S' ? 'Sakit (Tanpa Surat Dokter)' : ($rwyt->keterangan === 'I' ? 'Izin' : ($rwyt->keterangan === 'A' ? 'Alpa' : ($rwyt->keterangan === 'C' ? 'Cuti' : ($rwyt->keterangan === 'DIS' ? '1/2 Hari' : ($rwyt->keterangan === 'DR' ? 'Di Rumahkan' : '-')))))) }}
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
    <!-- jQuery (required for DataTables plugin) -->

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
@endsection
