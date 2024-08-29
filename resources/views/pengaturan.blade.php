@extends('layout.template')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
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
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Recent Orders -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- Block Tabs Alternative Style -->
                    <div class="block block-rounded">
                        <ul class="nav nav-tabs nav-tabs-alt" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="btabs-alt-static-home-tab" data-bs-toggle="tab"
                                    data-bs-target="#btabs-alt-static-home" role="tab"
                                    aria-controls="btabs-alt-static-home" aria-selected="true">Konfigurasi Cuti</button>
                            </li>
                            {{-- <li class="nav-item">
                                <button class="nav-link" id="btabs-alt-static-profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#btabs-alt-static-profile" role="tab"
                                    aria-controls="btabs-alt-static-profile" aria-selected="false">Profile</button>
                            </li> --}}
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="btabs-alt-static-home" role="tabpanel"
                                aria-labelledby="btabs-alt-static-home-tab" tabindex="0">
                                <form action="{{ route('pengaturan.cuti') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="block-content fs-sm">
                                        <div class="block-content block-content-full">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-4">
                                                        <label class="form-label">Pilih Divisi</label>
                                                        <select class="js-select2 form-select" id="example-select2-multiple"
                                                            name="id_divisi[]" style="width: 100%;"
                                                            data-placeholder="Pilih Divisi..." multiple>
                                                            <option></option>
                                                            @foreach ($divisi as $dvs)
                                                                <option value="{{$dvs->id_divisi}}">{{$dvs->nama_divisi}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="form-label">Set Jumlah Cuti</label>
                                                        <input class="form-control" type="number" name="sisa_cuti"
                                                            id="sisa_cuti" placeholder="Masukkan Jumlah Cuti" required>
                                                    </div>
                                                    <span class="text-danger">* Gunakan Dengan Bijak, Aksi Ini Tidak Dapat di Undo!</span>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="tab-pane" id="btabs-alt-static-profile" role="tabpanel"
                                aria-labelledby="btabs-alt-static-profile-tab" tabindex="0">
                                <h4 class="fw-normal">Profile Content</h4>
                                <p>...</p>
                            </div> --}}
                        </div>
                    </div>
                    <!-- END Block Tabs Alternative Style -->
                </div>
            </div>
            <!-- END Recent Orders -->
        </div>
        <!-- END Page Content -->
    </main>
@endsection

@section('javascript')
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>One.helpersOnLoad(['jq-select2']);</script>
@endsection
