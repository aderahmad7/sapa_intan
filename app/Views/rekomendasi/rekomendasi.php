<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>SI SAPA INTAN</title>
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>DataTables/datatables.css" />
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <?= view('partial/sidebar') ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- Filter Data berdasarkan rekomendasi (Pengadaan, Pemeliharaan, Perbaikan) -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Filter Data & Aksi</h4>
                                <div class="row align-items-end">
                                    <div class="col-md-8">
                                        <form id="filterForm">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="filterRekomendasi" class="form-label">Filter Rekomendasi</label>
                                                    <select class="form-select" id="filterRekomendasi" name="filterRekomendasi">
                                                        <option value="">Semua</option>
                                                        <option value="Perbaikan">Perbaikan</option>
                                                        <option value="Pemeliharaan">Pemeliharaan</option>
                                                        <option value="Pengadaan">Pengadaan</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">&nbsp;</label>
                                                    <div class="d-flex gap-2">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-filter me-1"></i>Terapkan Filter
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary" id="resetFilter">
                                                            <i class="fas fa-undo me-1"></i>Reset
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <label class="form-label">&nbsp;</label>
                                        <div class="d-flex gap-2 justify-content-end">
                                            <button type="button" class="btn btn-success" id="printButton">
                                                <i class="fas fa-print me-1"></i>Print Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tabel Data Rekomendasi -->
                <table id="myTable" class="display table border table-striped table-bordered text-nowrap">
                    <thead>
                        <tr>

                            <th>No</th>
                            <th>Pengusul</th>
                            <th>Tipe</th>
                            <th>Kondisi</th>
                            <th>Kepemilikan</th>
                            <th>Status</th>
                            <th>Rekomendasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <!-- Modal Lihat Data -->
                <div class="modal fade" id="bs-example-modal-lg-lihat" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Lihat Data</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <!-- Input kalKode (dropdown) -->
                                    <div class="mb-3">
                                        <label for="kalKodeLihat" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="kalKodeLihat" disabled>
                                    </div>
                                    <!-- Input usulTipeKode -->
                                    <div class="mb-3">
                                        <label for="usulTipeKodeLihat" class="form-label">Tipe</label>
                                        <input type="text" class="form-control" id="usulTipeKodeLihat" disabled>
                                    </div>
                                    <!-- Nomor Mesin -->
                                    <div class="mb-3">
                                        <label for="usulNoMesinLihat" class="form-label">Nomor Mesin</label>
                                        <input type="text" class="form-control" id="usulNoMesinLihat" disabled>
                                    </div>
                                    <!-- Nomor Rangka -->
                                    <div class="mb-3">
                                        <label for="usulNoRangkaLihat" class="form-label">Nomor Rangka</label>
                                        <input type="text" class="form-control" id="usulNoRangkaLihat" disabled>
                                    </div>
                                    <!-- Komoditi -->
                                    <div class="mb-3">
                                        <label for="usulKomoditiLihat" class="form-label">Komoditi</label>
                                        <input type="text" class="form-control" id="usulKomoditiLihat" disabled>
                                    </div>
                                    <!-- Kondisi -->
                                    <div class="mb-3">
                                        <label for="usulKonKodeLihat" class="form-label">Kondisi</label>
                                        <input type="text" class="form-control" id="usulKonKodeLihat" disabled>
                                    </div>
                                    <!-- Kepemilikan -->
                                    <div class="mb-3">
                                        <label for="usulKepemilikanLihat" class="form-label">Kepemilikan</label>
                                        <input type="text" class="form-control" id="usulKepemilikanLihat" disabled>
                                    </div>
                                    <!-- Luas Kinerja -->
                                    <div class="mb-3">
                                        <label for="usulLuasKinerjaLihat" class="form-label">Luas Kinerja</label>
                                        <input type="number" class="form-control" id="usulLuasKinerjaLihat" disabled>
                                    </div>
                                    <!-- Luas Jam -->
                                    <div class="mb-3">
                                        <label for="usulLuasJamLihat" class="form-label">Luas Jam</label>
                                        <input type="number" class="form-control" id="usulLuasJamLihat" disabled>
                                    </div>
                                    <!-- Foto Links (kalau ada role PPL/PROV) -->
                                    <div class="mb-3">
                                        <label class="form-label">Foto 1</label><br>
                                        <a id="linkFoto1Lihat" href="#" target="_blank"
                                            class="btn btn-info d-none">Lihat Foto 1</a>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto 2</label><br>
                                        <a id="linkFoto2Lihat" href="#" target="_blank"
                                            class="btn btn-info d-none">Lihat Foto 2</a>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto 3</label><br>
                                        <a id="linkFoto3Lihat" href="#" target="_blank"
                                            class="btn btn-info d-none">Lihat Foto 3</a>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Foto 4</label><br>
                                        <a id="linkFoto4Lihat" href="#" target="_blank"
                                            class="btn btn-info d-none">Lihat Foto 4</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Perbarui Rekomendasi, isi formnya cuma ada dropdown isinya Perbaikan, Pemeliharaan, Pengadaan-->
                <!-- Desain modalnya sama kayak modal lihat data -->
                <div class="modal fade" id="modalPerbaruiRekomendasi" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Perbarui Rekomendasi</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?= base_url('rekomendasi/update_rekomendasi') ?>"
                                    id="formPerbaruiRekomendasi">
                                    <!-- Dropdown rekomendasi -->
                                    <div class="mb-3">
                                        <label for="dropdownRekomendasi" class="form-label">Rekomendasi</label>
                                        <select class="form-select" id="dropdownRekomendasi" name="usulRekomendasiProv"
                                            required>
                                            <option value="" selected disabled>Pilih Rekomendasi</option>
                                            <option value="Perbaikan">Perbaikan</option>
                                            <option value="Pemeliharaan">Pemeliharaan</option>
                                            <option value="Pengadaan">Pengadaan</option>
                                        </select>
                                    </div>
                                    <!-- Hidden input untuk usulKode -->
                                    <input type="hidden" id="usulKodeRekomendasi" name="usulKode">
                                    <button type="submit" class="btn btn-primary">Simpan Rekomendasi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center text-muted">
                All Rights Reserved by Freedash. Designed and Developed by <a
                    href="https://adminmart.com/">Adminmart</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="<?= base_url() ?>dist/js/app-style-switcher.js"></script>
    <script src="<?= base_url() ?>dist/js/feather.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?= base_url() ?>dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url() ?>dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="<?= base_url() ?>assets/extra-libs/c3/d3.min.js"></script>
    <script src="<?= base_url() ?>assets/extra-libs/c3/c3.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="<?= base_url() ?>assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?= base_url() ?>assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?= base_url() ?>dist/js/pages/dashboards/dashboard1.min.js"></script>
    <script src="<?= base_url() ?>DataTables/datatables.js"></script>
    <!-- sweet alert -->
    <?php if (session()->getFlashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<?= session()->getFlashdata('error'); ?>',
                confirmButtonColor: '#3085d6',
            });
        </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                html: '<?= session()->getFlashdata('success'); ?>',
                confirmButtonColor: '#3085d6',
            });
        </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('info')): ?>
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                html: '<?= session()->getFlashdata('info'); ?>',
                confirmButtonColor: '#3085d6',
            });
        </script>
    <?php endif; ?>
    <script>
        var oTable;
        $(document).ready(function () {
            oTable = $('#myTable').DataTable({
                ajax: '<?php echo base_url(); ?>rekomendasi/datatable_rekomendasi',
                processing: true,
                serverSide: true,
                columns: [

                    {
                        data: null,
                        render: function (data, type, full, meta) {
                            var length = meta.settings._iDisplayStart;
                            return meta.row + length + 1;
                        },
                        searchable: false,
                        orderable: false,
                        width: "17px"
                    },

                    {
                        data: 'proTipeUsul',
                        render: function (data, type, row) {

                            if (data == "KAB")
                                return data + "<br>" + row.proKabNamaLengkap;
                            if (data == "PPL")
                                return data + "<br>" + row.proPplNama;
                        }
                    },
                    {
                        data: 'tipeNama',
                        render: function (data, type, row) {
                            return row.kalNama + "<br>" + data;
                        }
                    },
                    { data: 'usulKonKode' },
                    { data: 'usulKepemilikan' },
                    {
                        data: 'usulStatus',
                        render: function (data, type, row) {
                            const status = parseInt(data);
                            let label = '';
                            let badgeClass = '';
                            <?php if ($user['role'] == 'PROV'): ?>
                                switch (status) {

                                    case 4:
                                        label = 'Baru';
                                        badgeClass = 'bg-info';
                                        break;

                                    case 5:
                                        label = 'Ditolak Kabupaten';
                                        badgeClass = 'bg-danger';
                                        break;
                                    case 6:
                                        label = 'Diterima Provinsi';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 7:
                                        label = 'Ditolak Provinsi';
                                        badgeClass = 'bg-danger';
                                        break;
                                    default:
                                        label = 'Status Tidak Dikenal';
                                        badgeClass = 'bg-dark';
                                }
                            <?php elseif ($user['role'] == 'KAB'): ?>
                                switch (status) {

                                    case 2:
                                        label = 'Baru';
                                        badgeClass = 'bg-info';
                                        break;
                                    case 4:
                                        label = 'Diterima Kabupaten';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 5:
                                        label = 'Ditolak Kabupaten';
                                        badgeClass = 'bg-danger';
                                        break;
                                    case 6:
                                        label = 'Diterima Provinsi';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 7:
                                        label = 'Ditolak Provinsi';
                                        badgeClass = 'bg-danger';
                                        break;
                                    default:
                                        label = 'Status Tidak Dikenal';
                                        badgeClass = 'bg-dark';
                                }
                            <?php elseif ($user['role'] == 'BPP'): ?>
                                switch (status) {

                                    case 1:
                                        label = 'Baru';
                                        badgeClass = 'bg-info';
                                        break;
                                    case 2:
                                        label = 'Diterima BPP';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 3:
                                        label = 'Ditolak BPP';
                                        badgeClass = 'bg-danger';
                                        break;
                                    case 4:
                                        label = 'Diterima Kabupaten';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 5:
                                        label = 'Ditolak Kabupaten';
                                        badgeClass = 'bg-danger';
                                        break;
                                    case 6:
                                        label = 'Diterima Provinsi';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 7:
                                        label = 'Ditolak Provinsi';
                                        badgeClass = 'bg-danger';
                                        break;
                                    default:
                                        label = 'Status Tidak Dikenal';
                                        badgeClass = 'bg-dark';
                                }
                            <?php else: ?>
                                switch (status) {
                                    case 0:
                                        label = 'Draft';
                                        badgeClass = 'bg-secondary';
                                        break;
                                    case 1:
                                        label = 'Terkirim ke BPP';
                                        badgeClass = 'bg-info';
                                        break;
                                    case 2:
                                        label = 'Diterima BPP';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 3:
                                        label = 'Ditolak BPP';
                                        badgeClass = 'bg-danger';
                                        break;
                                    case 4:
                                        label = 'Diterima Kabupaten';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 5:
                                        label = 'Ditolak Kabupaten';
                                        badgeClass = 'bg-danger';
                                        break;
                                    case 6:
                                        label = 'Diterima Provinsi';
                                        badgeClass = 'bg-success';
                                        break;
                                    case 7:
                                        label = 'Ditolak Provinsi';
                                        badgeClass = 'bg-danger';
                                        break;
                                    default:
                                        label = 'Status Tidak Dikenal';
                                        badgeClass = 'bg-dark';
                                }
                            <?php endif; ?>

                            return `<span class="badge ${badgeClass}">${label}</span>`;
                        }
                    },
                    {
                        data: 'usulRekomendasiProv',
                        render: function (data, type, row) {
                            if (data) {
                                return `<span class="badge bg-success">${data}</span>`;
                            } else {
                                return `<span class="badge bg-secondary">Belum Ada Rekomendasi</span>`;
                            }
                        }
                    },
                    {

                        data: 'usulKode', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            var lihatData = '<a data-id="' + data + '" style="margin:0px 3px 0px 0px;" onclick="lihatData($(this));return false;" href="#" title="Lihat Data"><i class="fas fa-eye"></i></a>';
                            var rekomendasiProv = row.usulRekomendasiProv;
                            // tambahkan tombol perbarui rekomendasi, aku ingin menampilkan dalam bentuk modal. data-id usulKode dan usulRekomendasiProv
                            var lihatRekomendasi = '';
                            <?php if ($user['role'] == 'PROV'): ?>
                                lihatRekomendasi = '<a data-id="' + data + '" data-rekomendasi="' + rekomendasiProv + '" style="margin:0px 3px 0px 0px;" onclick="lihatRekomendasi($(this));return false;" href="#" title="Perbarui Rekomendasi"><i class="fas fa-check-circle"></i></a>';
                            <?php endif; ?>
                            return lihatData + ' ' + lihatRekomendasi;
                        }
                    }
                ]
            });

            // penanganan untuk filter data berdasarkan rekomendasi
            $('#filterForm').on('submit', function (e) {
                e.preventDefault();
                var filterRekomendasi = $('#filterRekomendasi').val();
                oTable.column(6).search(filterRekomendasi).draw();
            });

            $('#resetFilter').on('click', function() {
                $('#filterRekomendasi').val('');
                oTable.column(6).search('').draw();
            });

            // penanganan untuk print data
            $('#printButton').on('click', function () {
                var filterRekomendasi = $('#filterRekomendasi').val();
                var url = '<?= base_url('rekomendasi/print_rekomendasi') ?>';
                if (filterRekomendasi) {
                    url += '?rekomendasi=' + filterRekomendasi;
                }
                window.open(url, '_blank');
            });

            window.lihatData = function (element) {
                var usulKode = element.data('id');
                $.ajax({
                    url: '<?= base_url('dashboard/get_sapras_by_usulkode') ?>',
                    type: 'POST',
                    data: { usulKode: usulKode },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);

                        $('#kalKodeLihat').val(data.kalNama);
                        $('#usulTipeKodeLihat').val(data.tipeNama);
                        $('#usulNoMesinLihat').val(data.usulNoMesin);
                        $('#usulNoRangkaLihat').val(data.usulNoRangka);
                        $('#usulKomoditiLihat').val(data.usulKomoditi);
                        $('#usulKonKodeLihat').val(data.usulKonKode);
                        $('#usulKepemilikanLihat').val(data.usulKepemilikan);
                        $('#usulLuasKinerjaLihat').val(data.usulLuasKinerja);
                        $('#usulLuasJamLihat').val(data.usulLuasJam);

                        var url = '<?= base_url('uploads/') ?>';
                        if (data.usulFoto1) {
                            $('#linkFoto1Lihat').removeClass('d-none').attr('href', `${url}/${data.usulFoto1}`);
                        }
                        if (data.usulFoto2) {
                            $('#linkFoto2Lihat').removeClass('d-none').attr('href', `${url}/${data.usulFoto2}`);
                        }
                        if (data.usulFoto3) {
                            $('#linkFoto3Lihat').removeClass('d-none').attr('href', `${url}/${data.usulFoto3}`);
                        }
                        if (data.usulFoto4) {
                            $('#linkFoto4Lihat').removeClass('d-none').attr('href', `${url}/${data.usulFoto4}`);
                        }

                        $('#bs-example-modal-lg-lihat').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Gagal mengambil data sapras:', error);
                    }
                });
            };

            // fungsi untuk melihat rekomendasi, jika data rekomendasi ada maka set dropdown ke nilai rekomendasi tersebut, jika tidak ada maka set ke kosong
            window.lihatRekomendasi = function (element) {
                var usulKode = element.data('id');
                var rekomendasi = element.data('rekomendasi');

                $('#dropdownRekomendasi').val(rekomendasi || '');
                $('#usulKodeRekomendasi').val(usulKode);
                $('#modalPerbaruiRekomendasi').modal('show');
            };

        });
    </script>
</body>

</html>