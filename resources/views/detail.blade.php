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
        <!-- Page Content -->
        <div class="content">
            <!-- User Info -->
            <div class="btn btn-sm my-2">
                <a href="{{ route('karyawan') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="block block-rounded">
                <div class="block-content text-center">
                    <div class="py-4">
                        <div class="mb-3">
                            <img class="img-avatar" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                        </div>
                        <h1 class="fs-lg mb-0">
                            <span>{{ $karyawan[0]->nama_karyawan }} ({{ $karyawan[0]->divisi->nama_divisi }})</span>
                        </h1>
                        <p class="fs-sm fw-medium text-muted">{{ $karyawan[0]->bagian->nama_bagian }}</p>
                    </div>
                </div>
            </div>
            <!-- END User Info -->

            <!-- Past Orders -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Riwayat Tidak Masuk ({{ count($cuti) }})</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-simple">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cuti as $ct)
                                    <tr>
                                        <td class="text-center"><strong>{{ $loop->iteration }}</strong></td>
                                        <td class="text-center">
                                            {{ Carbon::parse($ct->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td class="text-center"><span
                                                class="badge" style="background-color: {{ $ct->keterangan === 'A' ? 'red' : ($ct->keterangan === 'SD' ? 'mediumblue' : ($ct->keterangan === 'C' ? 'black' : ($ct->keterangan === 'I' ? 'grey' : ($ct->keterangan === 'S' ? 'deepskyblue' : ($ct->keterangan === 'DIS' ? 'purple' : ($ct->keterangan === 'DR' ? 'green' : 'pink' ))))))}}">{{ $ct->keterangan === 'SD' ? 'Sakit (Surat Dokter)' : ($ct->keterangan === 'S' ? 'Sakit (Tanpa Surat Dokter)' : ($ct->keterangan === 'I' ? 'Izin' : ($ct->keterangan === 'A' ? 'Alpa' : ($ct->keterangan === 'C' ? 'Cuti' : ($ct->keterangan === 'DIS' ? '1/2 Hari' : ($ct->keterangan === 'DR' ? 'Di Rumahkan' : '-')))))) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Past Orders -->
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

    <!-- Page JS Code -->
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
@endsection
