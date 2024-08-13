@extends('layouts.app')

@section('title')
    HRIS | Karyawan Baru
@endsection

@section('css')
    <!-- third party css -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- third party css end -->
@endsection

@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">HUMAN RESOURCES INFORMATION SYSTEM</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <h4 class="text-center">DATA KARYAWAN BARU DEPARTEMEN</h4>
                <div class="row mt-3 mb-0">
                    <div class="col-20">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data-karyawan-baru"
                                        class="table table-sm table-bordered table-hover table-striped w-100">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>No</th>
                                                <th>No Scan</th>
                                                <th>Nama</th>
                                                <th>Departement</th>
                                                <th>Tgl Masuk</th>
                                                <th>Tgl Akhir Evaluasi</th>
                                                <th>Jabatan</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($dept_employes as $employe)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $employe->no_scan }}</td>
                                                    <td>{{ $employe->nama }}</td>
                                                    <td>{{ $employe->dept }}</td>
                                                    <td>{{ $employe->ftgl_masuk }}</td>
                                                    <td>{{ $employe->ftgl_evaluasi }}</td>
                                                    <td>{{ $employe->jabatan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive -->

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>

                <h5 class="text-danger mt-1 mb-0 fs-15">Note : </h5>
                <h6 class="text-muted fw-normal mt-1 mb-2">Mohon kirim Evaluasi Karyawan Baru H-7 Sebelum Masa
                    Training
                    Berakhir.
                </h6>


                <!-- end page title -->
                <h4 class="text-center mt-5">DATA KARYAWAN BARU SEMUA DEPARTEMEN</h4>
                <div class="row mt-3 mb-0">
                    <div class="col-20">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data-karyawan-semua"
                                        class="table table-sm table-bordered table-hover table-striped w-100">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>No</th>
                                                <th>No Scan</th>
                                                <th>Nama</th>
                                                <th>Departement</th>
                                                <th>Tgl Masuk</th>
                                                <th>Jabatan</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($all_employes as $employe)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $employe->no_scan }}</td>
                                                    <td>{{ $employe->nama }}</td>
                                                    <td>{{ $employe->dept }}</td>
                                                    <td>{{ $employe->ftgl_masuk }}</td>
                                                    <td>{{ $employe->jabatan }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive -->

                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>

            </div> <!-- container -->

        </div> <!-- content -->
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#data-karyawan-baru').DataTable({});

            $('#data-karyawan-semua').DataTable({});
        });
    </script>
@endsection
