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
                        + Tambah Data
                    </button>
                </div>
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Kode Tipe</th>
                            <th>Nama Alsintan</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <!--  Modal tambah -->
                <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Tambah Tipe</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('master_tipe/add_tipe') ?>" method="post">
                                    <div class="mb-3">
                                        <label for="accUsername" class="form-label">Kode Tipe</label>
                                        <input type="text" class="form-control" id="tipeKode" name="tipeKode"
                                            placeholder="Masukkan Kode" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accName" class="form-label">Nama Alsintan</label>
                                        <input type="text" class="form-control" id="tipeNama" name="tipeNama"
                                            placeholder="Masukkan Nama Lengkap" required>
                                    </div>
                                    
                                    
                                    <div class="mb-3" id="accKotaKodeContainer">
                                        <label for="accKotaKode" class="form-label">Kategori</label>
                                        <select class="form-select" id="tipeKalKode" name="tipeKalKode" required>
                                            <option value="" disabled selected>Pilih kategori</option>
                                            <?php foreach ($katlist as $kategoriList): ?>
                                               <option value="<?= $kategoriList['kalKode'] ?>"><?= $kategoriList['kalNama'] ?></option>
                                               
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                   
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Modal Edit (isinya sama kayak modal tambah) -->
                <div class="modal fade" id="bs-example-modal-lg-edit" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabelEdit" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabelEdit">Ubah Tipe</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('master_tipe/edit_tipe') ?>" method="post">
                                    <input type="hidden" id="tipeKodeEdit" name="tipeKodeEdit">
                                    <div class="mb-3">
                                        <label for="accNameEdit" class="form-label">Nama Alsintan</label>
                                        <input type="text" class="form-control" id="tipeNamaEdit" name="tipeNamaEdit"
                                            placeholder="Masukkan Nama" required>
                                    </div>
                                   
                                   
                                    <div class="mb-3" id="accKotaKodeContainerEdit">
                                        <label for="tipeKalKodeEdit" class="form-label">Kategori</label>
                                        <select class="form-select" id="tipeKalKodeEdit" name="tipeKalKodeEdit"
                                            required>
                                            <option value="" disabled selected>Pilih kategori</option>
                                            <?php foreach ($katlist as $kategoriList): ?>
                                                <option value="<?= $kategoriList['kalKode'] ?>"><?= $kategoriList['kalNama'] ?></option>
                                                
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

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
        $(document).ready(function () {
            $('#myTable').DataTable({
                ajax: '<?php echo base_url(); ?>master_tipe/datatable',
                processing: true,
                serverSide: true,
                columns:
                    [
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
                        { data: 'tipeKode' },
                        { data: 'tipeNama'},
                        { data: 'kalNama' },
                        {
                            data: 'tipeKode', searchable: false, orderable: false,
                            render: function (data, type, row) {
                                var edit = '<a data-id="' + data + '" style="margin :0px 1px 0px 0px ;" onclick="edit($(this));return false;" href="#" title="Ubah"><i class="fas fa-edit"></i></a>';
                                var hapus = '<a data-id="' + data + '" style="margin :0px 0px 0px 0px ;" onclick="return setModalHapus($(this));" href="#" title="Hapus"><i class="fas fa-trash"></i></a> ';
                                return edit + ' ' + hapus;
                            }
                        },
                    ]
            });

            // fungsi untuk mengisi modal edit dengan data yang dipilih berdasarkan username
            // namun sebelum itu, ambil data akun dari backend menggunakan AJAX
            // setelah itu, isi inputan dengan data yang diambil kemudian tampilkan modal edit
            // untuk inputan dropdown, jika role adalah PPL, maka akan muncul inputan untuk desa, kecamatan, Kota
            // jika role adalah BPP, maka akan muncul inputan untuk Kota
            // jika role adalah KAB, maka tidak akan muncul inputan apapun
            // ganti role, maka inputan yang tidak sesuai akan disembunyikan dan isinya akan dihapus
            // untuk dropdown kecamatan, akan diisi dengan data dari backend (dari fungsi dashboard/get_kecamatan_by_kota) berdasarkan kota yang dipilih lalu auto selected berdasarkan data yang diambil dari akun
            // untuk dropdown kota dan Tipe juga auto selected berdasarkan data yang diambil dari akun
            window.edit = function (element) {
                var username = element.data('id');
                var baseUrl = '<?= base_url('master_tipe/edit_tipe') ?>';
                $.ajax({
                    url: '<?= base_url('master_tipe/get_data_by_id') ?>',
                    type: 'POST',
                    data: { tipeKode: username },
                    dataType: 'json',
                    success: function (data) {
                        // tambahkan username menjadi parameter di url form action jadi dashboard/edit_akun/${username}
                       
                        
                        $('#tipeKodeEdit').val(data.tipeKode);
                        $('#tipeNamaEdit').val(data.tipeNama);
                        $('#tipeKalKodeEdit').val(data.tipeKalKode);
                        
                        // tampilkan modal edit
                        $('#bs-example-modal-lg-edit').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching akun data:', error);
                    }
                });
            };

           
            // fungsi hapus data berdasarkan username
            window.setModalHapus = function (element) {
                var username = element.data('id');
                Swal.fire({
                    title: 'Hapus Tipe',
                    text: "Apakah Anda yakin ingin menghapus Tipe ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('master_tipe/hapus_tipe') ?>',
                            type: 'POST',
                            data: { tipeKode: username },
                            success: function (response) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Tipe telah dihapus.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    'Gagal!',
                                    'Tipe gagal dihapus.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            };
        });
    </script>
</body>

</html>