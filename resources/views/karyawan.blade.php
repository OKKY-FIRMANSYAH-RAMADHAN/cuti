@extends('layout.template')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endsection

@section('content')
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
                @if (session()->get('username') == 'ea')
                <div class="mt-3 mt-md-0 ms-md-3 space-x-1">
                    <button type="button" class="btn btn-sm btn-secondary push" data-bs-toggle="modal"
                        data-bs-target="#modal-block-popin"> <i class="fa fa-plus opacity-50"></i> Tambah Karyawan</button>
                    <button type="button" class="btn btn-sm btn-success push" data-bs-toggle="modal"
                        data-bs-target="#modal-block-import"> <i class="fa fa-upload opacity-50"></i> Import
                        Karyawan</button>
                </div>
                @endif
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Dynamic Table Responsive -->
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-responsive class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
                        <thead>
                            <tr>
                                <th class="text-center fs-sm d-none d-md-table-cell" style="width: 10%;">No</th>
                                <th>Nama Karyawan</th>
                                <th class="d-none d-md-table-cell">Bagian</th>
                                <th class="d-none d-md-table-cell">Divisi</th>
                                <th class="text-center fs-sm">Sisa Cuti</th>
                                <th class="no-print text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawan as $krywn)
                                <tr>
                                    <td class="text-center fs-sm d-none d-md-table-cell">{{ $loop->iteration }}</td>
                                    <td>{{ $krywn->nama_karyawan }}</td>
                                    <td class="d-none d-md-table-cell">{{ $krywn->bagian->nama_bagian ?? '-' }}</td>
                                    <td class="d-none d-md-table-cell">{{ $krywn->divisi->nama_divisi ?? '-' }}</td>
                                    <td class="text-center"><strong>{{ $krywn->sisa_cuti }}</strong></td>
                                    <td class="fw-semibold fs-sm text-center">
                                        @if (session()->get('username') == 'ea')
                                            <button type="button" class="btn btn-sm btn-success cutiButton"
                                                data-id="{{ $krywn->id_karyawan }}"
                                                data-name="{{ $krywn->nama_karyawan }}"><i
                                                    class="fa fa-fw fa-calendar-plus"></i></button>
                                            <button type="button" class="btn btn-sm btn-warning editButton"
                                                data-id="{{ $krywn->id_karyawan }}"
                                                data-name="{{ $krywn->nama_karyawan }}"
                                                data-idbagian="{{ $krywn->id_bagian }}"
                                                data-iddivisi="{{ $krywn->id_divisi }}"><i
                                                    class="fa fa-fw fa-pencil-alt"></i></button>
                                            <a href="{{ route('karyawan.delete', ['id' => $krywn->id_karyawan]) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus karyawan ini? Menghapus karyawan berpengaruh terhadap data yang berelasi')"><i
                                                    class="fa fa-fw fa-trash"></i></a>
                                        @endif
                                        <a href="{{ route('karyawan.detail', ['id' => $krywn->id_karyawan]) }}"
                                            class="btn btn-sm btn-info"><i class="fa fa-fw fa-info-circle"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Dynamic Table Responsive -->
        </div>
        <!-- END Page Content -->
    </main>

    {{-- Pop In Block Modal --}}
    <div class="modal fade" id="modal-block-popin" tabindex="-1" role="dialog" aria-labelledby="modal-block-popin"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Tambah Data Karyawan</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="block-content fs-sm">
                            <div class="block-content block-content-full">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Nama Karyawan</label>
                                            <input class="form-control" type="text" name="nama_karyawan"
                                                id="nama_karyawan" placeholder="Nama Karyawan" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Bagian</label>
                                            <select class="form-select" id="id_bagian" name="id_bagian" required>
                                                <option selected value="" disabled>Pilih Bagian</option>
                                                @foreach ($bagian as $bgn)
                                                    <option value="{{ $bgn->id_bagian }}">{{ $bgn->nama_bagian }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Divisi</label>
                                            <select class="form-select" id="id_divisi" name="id_divisi" required>
                                                <option selected value="" disabled>Pilih Divisi</option>
                                                @foreach ($divisi as $dvs)
                                                    <option value="{{ $dvs->id_divisi }}">{{ $dvs->nama_divisi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END Pop In Block Modal --}}

    {{-- Import Karyawan --}}
    <div class="modal fade" id="modal-block-import" tabindex="-1" role="dialog" aria-labelledby="modal-block-import"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Import Data Karyawan</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('karyawan.import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="block-content fs-sm">
                            <div class="block-content block-content-full">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Input File Excel</label>
                                            <input class="form-control" type="file" name="file" id="file"
                                                placeholder="Excel" required>
                                                <span class="text-danger">* Download Format Excel </span><a href="{{ asset('assets/template_karyawan.xlsx') }}">Disini</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="block-content block-content-full text-end bg-body">
                            <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END Import Karyawan --}}

    {{-- Modal Edit Data --}}
    <div class="modal" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Edit Data Karyawan</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('karyawan.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="block-content fs-sm">
                            <div class="block-content block-content-full">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Nama Karyawan</label>
                                            <input class="form-control" type="text" name="nama_karyawan"
                                                id="nama_karyawan" placeholder="Nama Karyawan" required>
                                            <input class="form-control" type="hidden" name="id_karyawan"
                                                id="id_karyawan" placeholder="Id Karyawan" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Bagian</label>
                                            <select class="form-select" id="id_bagian_update" name="id_bagian" required>
                                                <option selected value="" disabled>Pilih Bagian</option>
                                                @foreach ($bagian as $bgn)
                                                    <option value="{{ $bgn->id_bagian }}">{{ $bgn->nama_bagian }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Divisi</label>
                                            <select class="form-select" id="id_divisi_update" name="id_divisi" required>
                                                <option selected value="" disabled>Pilih Divisi</option>
                                                @foreach ($divisi as $dvs)
                                                    <option value="{{ $dvs->id_divisi }}">{{ $dvs->nama_divisi }}
                                                    </option>
                                                @endforeach
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
    {{-- End Modal Edit Data --}}

    {{-- Modal Tambah Cuti --}}
    <div class="modal" id="cutiModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-vcenter"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Tambah Cuti</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('karyawan.cuti') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="block-content fs-sm">
                            <div class="block-content block-content-full">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Nama Karyawan</label>
                                            <input class="form-control" type="text" name="nama_karyawan"
                                                id="nama_karyawan" placeholder="Nama Karyawan" required disabled>
                                            <input class="form-control" type="hidden" name="id_karyawan"
                                                id="id_karyawan" placeholder="Id Karyawan" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label" for="example-file-input">Tanggal Cuti</label>
                                            <input class="form-control" type="date" name="tanggal" id="tanggal"
                                                placeholder="Tanggal" required>
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
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Tambah Cuti --}}
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

    <script>
        var editButtons = document.querySelectorAll(".editButton");
        editButtons.forEach(function(editButton) {
            editButton.addEventListener("click", function() {
                var id = editButton.getAttribute("data-id");
                var name = editButton.getAttribute("data-name");
                var idbagian = editButton.getAttribute("data-idbagian");
                var iddivisi = editButton.getAttribute("data-iddivisi");

                var modal = document.getElementById("editModal");
                var namaKaryawanInput = modal.querySelector("#nama_karyawan");
                var idKaryawanInput = modal.querySelector("#id_karyawan");

                namaKaryawanInput.value = name;
                idKaryawanInput.value = id;

                // Temukan elemen select
                var selectElement = document.getElementById('id_bagian_update');
                var selectDivisi = document.getElementById('id_divisi_update');

                for (var i = 0; i < selectElement.options.length; i++) {
                    if (selectElement.options[i].value == idbagian) {
                        selectElement.options[i].selected = true;
                        break;
                    }
                }

                for (var i = 0; i < selectDivisi.options.length; i++) {
                    if (selectDivisi.options[i].value == iddivisi) {
                        selectDivisi.options[i].selected = true;
                        break;
                    }
                }

                var editModal = new bootstrap.Modal(modal);
                editModal.show();
            });
        });
    </script>
    <script>
        var cutiButtons = document.querySelectorAll(".cutiButton");
        cutiButtons.forEach(function(cutiButtons) {
            cutiButtons.addEventListener("click", function() {
                var id = cutiButtons.getAttribute("data-id");
                var name = cutiButtons.getAttribute("data-name");
                var modal = document.getElementById("cutiModal");
                var namaKaryawan = modal.querySelector("#nama_karyawan");
                var idKaryawan = modal.querySelector("#id_karyawan");
                namaKaryawan.value = name;
                idKaryawan.value = id;
                var cutiModal = new bootstrap.Modal(modal);
                cutiModal.show();
            });
        });
    </script>
@endsection
