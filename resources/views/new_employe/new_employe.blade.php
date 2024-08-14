@extends('layouts.app')

@section('title')
    HRIS | Karyawan Baru
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
    <div class="content-page">
        <!-- Start content -->
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
                <!-- End page title -->

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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="text-danger mt-1 mb-0 fs-15">Note : </h5>
                <h6 class="text-muted fw-normal mt-1 mb-2">Mohon kirim Evaluasi Karyawan Baru H-7 Sebelum Masa
                    Training
                    Berakhir.
                </h6>

                @if (auth()->user()->dept == 'HRD')
                    <h4 class="text-center mt-5">DATA KARYAWAN BARU SEMUA DEPARTEMEN</h4>
                    <form method="POST" action="{{ route('sendmail-new-employee') }}">
                        @csrf
                        <div class="row mt-3 mb-0" x-data="{ checkedItems: [] }">
                            <div class="col-20">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-start">
                                            <button class="btn btn-success me-2 mb-2" type="submit" name="send-email">
                                                <i class="fa fa-file-excel"></i> Export to Excel
                                            </button>
                                            <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" />
                                        </div>
                                        <div class="table-responsive">
                                            <table id="data-karyawan-semua"
                                                class="table table-sm table-bordered table-hover table-striped w-100">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>*</th>
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
                                                            <td>
                                                                @if ($employe['status_email_kontrak'] != 2)
                                                                    <input type="checkbox" class="checkbox" name="no_scan[]"
                                                                        :value="'{{ $employe['no_scan'] }}/{{ $employe['nama'] }}/{{ $employe['dept'] }}/{{ $employe['tgl_masuk'] }}/{{ $employe['tgl_evaluasi'] }}/{{ $employe['jabatan'] }}'"
                                                                        x-model="checkedItems"
                                                                        x-bind:checked="checkedItems.includes(
                                                                            '{{ $employe['no_scan'] }}')">
                                                                @else
                                                                    <input type="checkbox" class="checkbox" name="no_scan[]"
                                                                        checked disabled>
                                                                @endif
                                                            </td>
                                                            <td>{{ $employe->no_scan }}</td>
                                                            <td>{{ $employe->nama }}</td>
                                                            <td>{{ $employe->dept }}</td>
                                                            <td>{{ $employe->tgl_masuk }}</td>
                                                            <td>{{ $employe->jabatan }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-end mb-2">
                                @if (auth()->user()->dept == 'HRD')
                                    <button x-show="checkedItems.length > 0" class="btn btn-primary me-2" type="submit"
                                        name="send-email">
                                        <i class="fa fa-envelope"></i> Kirim Email
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
        <!-- End content -->
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#data-karyawan-baru').DataTable({});

            $('#data-karyawan-semua').DataTable({});
        });
    </script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
