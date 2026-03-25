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
                <!-- Tombol Tambah -->
                <div class="mb-3">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg"
                        class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>
                </div>
                <table id="myTable" class="display table border table-striped table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelompok</th>
                            <th>Nama Ketua Kelompok</th>
                            <th>File KTP</th>
                            <th>Nomor Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <!--  Modal content for the above example -->
                <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Tambah Data</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('poktan/add_poktan') ?>" method="post"
                                    enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="pokPplNama" class="form-label">Nama Kelompok</label>
                                        <input type="text" class="form-control" id="pokPplNama" name="pokPplNama"
                                            required value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pokPplNamaKetua" class="form-label">Nama Ketua Kelompok</label>
                                        <input type="text" class="form-control" id="pokPplNamaKetua"
                                            name="pokPplNamaKetua" required value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pokPplFileKTP" class="form-label">File KTP</label>
                                        <input required type="file" class="form-control" id="pokPplFileKTP"
                                            name="pokPplFileKTP" accept=".jpg, .jpeg, .png">
                                    </div>
                                    <div class="mb-3">
                                        <label for="pokPplTelp" class="form-label">Nomor Telepon</label>
                                        <input required type="text" class="form-control" id="pokPplTelp"
                                            name="pokPplTelp" value="">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!--  Modal edit for the above example -->
                <div class="modal fade" id="bs-example-modal-lg-edit" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Edit Data</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('dashboard/edit_sapras') ?>" method="post"
                                    enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="pokPplNamaEdit" class="form-label">Nama Kelompok</label>
                                        <input type="text" class="form-control" id="pokPplNamaEdit"
                                            name="pokPplNamaEdit" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pokPplNamaKetuaEdit" class="form-label">Nama Ketua Kelompok</label>
                                        <input type="text" class="form-control" id="pokPplNamaKetuaEdit"
                                            name="pokPplNamaKetuaEdit" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pokPplFileKTPEdit" class="form-label">File KTP</label>
                                        <input type="file" class="form-control" id="pokPplFileKTPEdit"
                                            name="pokPplFileKTPEdit" accept=".jpg, .jpeg, .png">
                                        <a id="linkKTPEdit" href="<?= esc(base_url()) ?>" target="_blank"
                                            class="btn btn-info mt-2 d-none">Lihat KTP</a>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pokPplTelpEdit" class="form-label">Nomor Telepon</label>
                                        <input required type="text" class="form-control" id="pokPplTelpEdit"
                                            name="pokPplTelpEdit">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center text-muted">
            All Rights Reserved by Freedash. Designed and Developed by <a href="https://adminmart.com/">Adminmart</a>.
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
                ajax: {
                    url: '<?= base_url('poktan/datatable') ?>',
                    type: 'GET',
                    dataSrc: function (json) {
                        // DataTables expects 'data' property in response
                        return json.data || [];
                    }
                },
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
                    { data: 'pokPplNama' },
                    { data: 'pokPplNamaKetua' },
                    {
                        data: 'pokPplFileKTP', render: function (data) {
                            if (data) {
                                return '<a href="' + '<?= base_url('uploads/') ?>' + data + '" target="_blank">Lihat KTP</a>';
                            }
                            return '-';
                        }
                    },
                    { data: 'pokPplTelp' },
                    {
                        data: 'pokKode',
                        render: function (data, type, row) {
                            // Tombol aksi isinya edit dan delete
                            var edit = '<a data-id="' + data + '" style="margin:0px 3px 0px 0px;" onclick="edit($(this));return false;" href="#" title="Ubah"><i class="fas fa-edit"></i></a>';
                            var del = '<a data-id="' + data + '" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus" onclick="return setModalHapus($(this));" href="#" title="Hapus"><i class="fas fa-trash"></i></a>';
                            return edit + del;
                        },
                        searchable: false,
                        orderable: false
                    }
                ]
            });
        });

        // fungsi hapus data berdasarkan username
        window.setModalHapus = function (element) {
            var pokKode = element.data('id');
            Swal.fire({
                title: 'Hapus Data',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('poktan/hapus_poktan') ?>',
                        type: 'POST',
                        data: { pokKode: pokKode },
                        success: function (response) {
                            Swal.fire(
                                'Terhapus!',
                                'Data telah dihapus.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                'Gagal!',
                                'Data gagal dihapus.',
                                'error'
                            );
                        }
                    });
                }
            });
        };

        window.edit = function (element) {
            var pokKode = element.data('id');
            var baseUrl = '<?= base_url('poktan/edit_poktan') ?>';
            $.ajax({
                url: '<?= base_url('poktan/get_poktan_by_pokkode') ?>',
                type: 'POST',
                data: { pokKode: pokKode },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    // tambahkan username menjadi parameter di url form action jadi dashboard/edit_akun/${username}
                    var formAction = `${baseUrl}/${data.pokKode}`;
                    $('#bs-example-modal-lg-edit form').attr('action', formAction);
                    $('#pokPplNamaEdit').val(data.pokPplNama);
                    $('#pokPplNamaKetuaEdit').val(data.pokPplNamaKetua);
                    $('#pokPplTelpEdit').val(data.pokPplTelp);


                    var url = '<?= base_url('uploads/') ?>';
                    var foto4 = `${url}/${data.pokPplFileKTP}`;
                    $('#linkKTPEdit').removeClass('d-none').attr('href', foto4);
                    // tampilkan modal edit
                    $('#bs-example-modal-lg-edit').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching akun data:', error);
                }
            });
        };
    </script>
</body>

</html>