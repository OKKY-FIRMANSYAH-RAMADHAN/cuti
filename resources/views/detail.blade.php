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
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-simple">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Keterangan</th>
                                    @if (session()->get('username') == 'ea')
                                        <th class="text-center">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cuti as $ct)
                                    <tr>
                                        <td class="text-center"><strong>{{ $loop->iteration }}</strong></td>
                                        <td class="text-center">
                                            {{ Carbon::parse($ct->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                        <td class="text-center"><span class="badge"
                                                style="background-color: {{ $ct->keterangan === 'A' ? 'red' : ($ct->keterangan === 'SD' ? 'mediumblue' : ($ct->keterangan === 'C' ? 'black' : ($ct->keterangan === 'I' ? 'grey' : ($ct->keterangan === 'S' ? 'deepskyblue' : ($ct->keterangan === 'DIS' ? 'purple' : ($ct->keterangan === 'DR' ? 'green' : 'pink')))))) }}">{{ $ct->keterangan === 'SD' ? 'Sakit (Surat Dokter)' : ($ct->keterangan === 'S' ? 'Sakit (Tanpa Surat Dokter)' : ($ct->keterangan === 'I' ? 'Izin' : ($ct->keterangan === 'A' ? 'Alpa' : ($ct->keterangan === 'C' ? 'Cuti' : ($ct->keterangan === 'DIS' ? '1/2 Hari' : ($ct->keterangan === 'DR' ? 'Di Rumahkan' : '-')))))) }}
                                        </td>
                                        @if (session()->get('username') == 'ea')
                                            <td class="fw-semibold fs-sm text-center">
                                                <button type="button" class="btn btn-sm btn-warning editButton"
                                                    data-id="{{ $ct->id_cuti }}" data-tanggal="{{ $ct->tanggal }}"
                                                    data-keterangan="{{ $ct->keterangan }}"><i
                                                        class="fa fa-fw fa-pencil-alt"></i></button>
                                                <a href="{{ route('cuti.delete', ['id' => $ct->id_cuti]) }}"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus cuti ini?')"><i
                                                        class="fa fa-fw fa-trash"></i></a>
                                            </td>
                                        @endif
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
    <div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Edit Data Cuti</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('cuti.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="block-content fs-sm">
                            <div class="block-content block-content-full">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Tanggal Cuti</label>
                                            <input class="form-control" type="date" name="tanggal" id="tanggal"
                                                placeholder="Tanggal" required>
                                            <input class="form-control" type="hidden" name="id_cuti" id="id_cuti"
                                                required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Alasan Cuti</label>
                                            <select class="form-select" id="keterangan" name="keterangan" required>
                                                <option selected value="" disabled>Pilih Alasan</option>
                                                <option value="A">Alpa</option>
                                                <option value="C">Cuti</option>
                                                <option value="DIS">1/2 Hari</option>
                                                <option value="DR">Di Rumahkan</option>
                                                <option value="I">Izin</option>
                                                <option value="SD">Sakit (Surat Dokter)</option>
                                                <option value="S">Sakit (Tanpa Surat Dokter)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

    <script>
        var editButtons = document.querySelectorAll(".editButton");
        editButtons.forEach(function(editButton) {
            editButton.addEventListener("click", function() {
                var id = editButton.getAttribute("data-id");
                var tanggal = editButton.getAttribute("data-tanggal");
                var keterangan = editButton.getAttribute("data-keterangan");

                var modal = document.getElementById("editModal");
                var tanggalInput = modal.querySelector("#tanggal");
                var idCutiInput = modal.querySelector("#id_cuti");

                tanggalInput.value = tanggal;
                idCutiInput.value = id;

                // Temukan elemen select
                var selectElement = document.getElementById('keterangan');

                for (var i = 0; i < selectElement.options.length; i++) {
                    if (selectElement.options[i].value == keterangan) {
                        selectElement.options[i].selected = true;
                        break;
                    }
                }

                var editModal = new bootstrap.Modal(modal);
                editModal.show();
            });
        });
    </script>
@endsection
