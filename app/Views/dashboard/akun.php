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
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Kab/Kota</th>
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
                                <h4 class="modal-title" id="myLargeModalLabel">Tambah Akun</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('dashboard/add_akun') ?>" method="post">
                                    <div class="mb-3">
                                        <label for="accUsername" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="accUsername" name="accUsername"
                                            placeholder="Masukkan Username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accName" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="accName" name="accName"
                                            placeholder="Masukkan Nama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accPasswd" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="accPasswd" name="accPasswd"
                                            placeholder="Masukkan Password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accNoWhatsapp" class="form-label">Nomor WhatsApp</label>
                                        <input type="text" class="form-control" id="accNoWhatsapp" name="accNoWhatsapp"
                                            placeholder="Masukkan Nomor WhatsApp" required>
                                    </div>
                                    <!-- Tambahkan input untuk accRole -->
                                    <div class="mb-3">
                                        <label for="accRole" class="form-label">Role</label>
                                        <select class="form-select" id="accRole" name="accRole" required>
                                            <option value="" disabled selected>Pilih Role</option>
                                            <!-- PROV bisa milih KAB, BPP, PPL -->
                                            <!-- KAB bisa milih BPP, PPL -->
                                            <!-- BPP bisa milih PPL -->
                                            <?php if ($user['role'] == 'PROV'): ?>
                                                <option value="KAB">KAB</option>
                                                <option value="BPP">BPP</option>
                                                <option value="PPL">PPL</option>
                                            <?php elseif ($user['role'] == 'KAB'): ?>
                                                <option value="BPP">BPP</option>
                                                <option value="PPL">PPL</option>
                                            <?php elseif ($user['role'] == 'BPP'): ?>
                                                <option value="PPL">PPL</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <!-- Tambahkan input untuk accKotaKode (kode kota) dropdown -->
                                    <?php //print_r($user);?>
                                    <div class="mb-3 d-none" id="accKotaKodeContainer">
                                        <label for="accKotaKode" class="form-label">Kota</label>
                                        <select class="form-select" id="accKotaKode" name="accKotaKode" required>
                                            <option value="" disabled selected>Pilih Kota</option>
                                            <?php foreach ($kotaList as $kota): ?>
                                                <?php if ($user['role'] != 'PROV'): ?>
                                                    <?php if ($kota['kotaKode']==$user['kotaKode']): ?>
                                                        <option value="<?= $kota['kotaKode'] ?>"><?= $kota['kotaNama'] ?></option>
                                                    <?php endif; ?>
                                                <?php elseif ($user['role'] == 'PROV'): ?>
                                                    <option value="<?= $kota['kotaKode'] ?>"><?= $kota['kotaNama'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- Tambahkan input untuk accKcmKode (kode kecamatan) dropdown -->
                                    <div class="mb-3 d-none" id="accKcmKodeContainer">
                                        <label for="accKcmKode" class="form-label">Kecamatan</label>
                                        <select class="form-select" id="accKcmKode" name="accKcmKode" required>
                                            <option value="" disabled selected>Pilih Kecamatan</option>
                                            <!-- Kecamatannya akan diisi melalui AJAX berdasarkan kota yang dipilih -->
                                            <!-- Contoh: <option value="kcm1">Kecamatan 1</option> -->
                                        </select>
                                    </div>
                                    <!-- Tambahkan input untuk accDesa -->
                                    <div class="mb-3 d-none" id="accDesaContainer">
                                        <label for="accDesa" class="form-label">Desa</label>
                                        <input type="text" class="form-control" id="accDesa" name="accDesa"
                                            placeholder="Masukkan Desa" required>
                                    </div>
                                    <!-- Tambahkan input untuk accInsKode (kode instanse) dropdown -->
                                    <div class="mb-3">
                                        <label for="accInsKode" class="form-label">Instansi</label>
                                        <select class="form-select" id="accInsKode" name="accInsKode" required>
                                            <?php if ($user['role'] == 'PROV'): ?>
                                            <option value="" disabled selected>Pilih Instansi</option>
                                             <?php endif; ?>
                                            <?php foreach ($instansiList as $instansi): ?>
                                                <?php if ($user['role'] != 'PROV'): ?>
                                                    <?php if ($instansi['insKode']==$user['insKode']): ?>
                                                        <option value="<?= $instansi['insKode'] ?>" <?=($user['insKode']==$instansi['insKode']?"selected":"");?>>
                                                            <?= $instansi['insNamaLengkap'] ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php elseif ($user['role'] == 'PROV'): ?>
                                                    <option value="<?= $instansi['insKode'] ?>" <?=($user['insKode']==$instansi['insKode']?"selected":"");?>>
                                                    <?= $instansi['insNamaLengkap'] ?>
                                                </option>
                                                <?php endif; ?>
                                                
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
                                <h4 class="modal-title" id="myLargeModalLabelEdit">Ubah Akun</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('dashboard/edit_akun') ?>" method="post">
                                    <input type="hidden" id="accUsernameEdit" name="accUsernameEdit">
                                    <div class="mb-3">
                                        <label for="accNameEdit" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="accNameEdit" name="accNameEdit"
                                            placeholder="Masukkan Nama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accPasswdEdit" class="form-label">Password (opsional)</label>
                                        <input type="password" class="form-control" id="accPasswdEdit"
                                            name="accPasswdEdit"
                                            placeholder="Masukkan Password (kosongkan jika tidak ingin mengubah)">
                                    </div>
                                    <div class="mb-3">
                                        <label for="accNoWhatsappEdit" class="form-label">Nomor WhatsApp</label>
                                        <input type="text" class="form-control" id="accNoWhatsappEdit"
                                            name="accNoWhatsappEdit" placeholder="Masukkan Nomor WhatsApp" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accRoleEdit" class="form-label">Role</label>
                                        <select class="form-select" id="accRoleEdit" name="accRoleEdit" required>
                                            <option value="" disabled selected>Pilih Role</option>
                                            <!-- PROV bisa milih KAB, BPP, PPL -->
                                            <!-- KAB bisa milih BPP, PPL -->
                                            <!-- BPP bisa milih PPL -->
                                            <?php if ($user['role'] == 'PROV'): ?>
                                                <option value="KAB">KAB</option>
                                                <option value="BPP">BPP</option>
                                                <option value="PPL">PPL</option>
                                            <?php elseif ($user['role'] == 'KAB'): ?>
                                                <option value="BPP">BPP</option>
                                                <option value="PPL">PPL</option>
                                            <?php elseif ($user['role'] == 'BPP'): ?>
                                                <option value="PPL">PPL</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 d-none" id="accKotaKodeContainerEdit">
                                        <label for="accKotaKodeEdit" class="form-label">Kota</label>
                                        <select class="form-select" id="accKotaKodeEdit" name="accKotaKodeEdit"
                                            required>
                                            <option value="" disabled selected>Pilih Kota</option>
                                            <?php foreach ($kotaList as $kota): ?>
                                                <?php if ($user['role'] != 'PROV'): ?>
                                                    <?php if ($kota['kotaKode']==$user['kotaKode']): ?>
                                                        <option value="<?= $kota['kotaKode'] ?>"><?= $kota['kotaNama'] ?></option>
                                                    <?php endif; ?>
                                                <?php elseif ($user['role'] == 'PROV'): ?>
                                                    <option value="<?= $kota['kotaKode'] ?>"><?= $kota['kotaNama'] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 d-none" id="accKcmKodeContainerEdit">
                                        <label for="accKcmKodeEdit" class="form-label">Kecamatan</label>
                                        <select class="form-select" id="accKcmKodeEdit" name="accKcmKodeEdit" required>
                                            <option value="" disabled selected>Pilih Kecamatan</option>
                                            <!-- Kecamatannya akan diisi melalui AJAX berdasarkan kota yang dipilih -->
                                            <!-- Contoh: <option value="kcm1">Kecamatan 1</option> -->
                                        </select>
                                    </div>
                                    <div class="mb-3 d-none" id="accDesaContainerEdit">
                                        <label for="accDesaEdit" class="form-label">Desa</label>
                                        <input type="text" class="form-control" id="accDesaEdit" name="accDesaEdit"
                                            placeholder="Masukkan Desa" required>
                                    </div>
                                    <div class="mb-3 d-none">
                                        <label for="accInsKodeEdit" class="form-label">Instansi</label>
                                        <select class="form-select" id="accInsKodeEdit" name="accInsKodeEdit" required>
                                            <option value="" disabled selected>Pilih Instansi</option>
                                            <?php foreach ($instansiList as $instansi): ?>
                                                <option value="<?= $instansi['insKode'] ?>">
                                                    <?= $instansi['insNamaLengkap'] ?>
                                                </option>
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
                ajax: '<?php echo base_url(); ?>dashboard/datatable_akun',
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
                        { data: 'accUsername' },
                        { data: 'accNama',
                            render: function (data, type, row) {
                                return data + '<br>No. Tep : ' + row.accNoWhatsapp;
                            } 
                        
                        },
                        { data: 'accRole' },
                        { data: 'accDesa',
                            render: function (data, type, row) {
                                if (row.accRole=="PPL")
                                    return data + '<br>' + row.kcmNama + '<br>' + row.kotaNama;
                                else if (row.accRole=="KAB")
                                    return row.insNamaLengkap;
                                else
                                    return row.kotaNama;
                            } 
                        
                        },
                        {
                            data: 'accUsername', searchable: false, orderable: false,
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
            // untuk dropdown kota dan instansi juga auto selected berdasarkan data yang diambil dari akun
            window.edit = function (element) {
                var username = element.data('id');
                var baseUrl = '<?= base_url('dashboard/edit_akun') ?>';
                $.ajax({
                    url: '<?= base_url('dashboard/get_akun_by_username') ?>',
                    type: 'POST',
                    data: { accUsername: username },
                    dataType: 'json',
                    success: function (data) {
                        // tambahkan username menjadi parameter di url form action jadi dashboard/edit_akun/${username}
                        var formAction = `${baseUrl}/${username}`;
                        $('#bs-example-modal-lg-edit form').attr('action', formAction);
                        $('#accUsernameEdit').val(data.accUsername);
                        $('#accNameEdit').val(data.accNama);
                        $('#accPasswdEdit').val('');
                        $('#accNoWhatsappEdit').val(data.accNoWhatsapp);
                        $('#accRoleEdit').val(data.accRole).change();
                        $('#accInsKodeEdit').val(data.accInsKode).change();

                        //jika role adalah PPL, maka akan muncul inputan untuk desa, kecamatan, Kota
                        if (data.accRole === 'PPL') {
                            $('#accKotaKodeContainerEdit').removeClass('d-none');
                            $('#accKcmKodeContainerEdit').removeClass('d-none');
                            $('#accDesaContainerEdit').removeClass('d-none');
                            $('#accKotaKodeEdit').val(data.accKotaKode).change(
                                // munculkan kecamatan berdasarkan kota yang dipilih dari backend get_kecamatan_by_kota
                                $.ajax({
                                    url: '<?= base_url('dashboard/get_kecamatan_by_kota') ?>',
                                    type: 'POST',
                                    data: { kotaKode: data.accKotaKode },
                                    dataType: 'json',
                                    success: function (kecamatanData) {
                                        var options = '<option value="" disabled selected>Pilih Kecamatan</option>';
                                        if (kecamatanData.length > 0) {
                                            $.each(kecamatanData, function (index, item) {
                                                options += '<option value="' + item.kcmKode + '">' + item.kcmNama + '</option>';
                                            });
                                            $('#accKcmKodeContainerEdit').removeClass('d-none');
                                        } else {
                                            $('#accKcmKodeContainerEdit').addClass('d-none');
                                        }
                                        $('#accKcmKodeEdit').html(options).val(data.accKcmKode).change();
                                    },
                                    error: function (xhr, status, error) {
                                        console.error('Error fetching kecamatan:', error);
                                        $('#accKcmKodeContainerEdit').addClass('d-none');
                                    }
                                })
                            );
                            $('#accDesaEdit').val(data.accDesa);
                        } else if (data.accRole === 'BPP') {
                            $('#accKotaKodeContainerEdit').removeClass('d-none');
                            $('#accKcmKodeContainerEdit').addClass('d-none');
                            $('#accDesaContainerEdit').addClass('d-none');
                            $('#accKotaKodeEdit').val(data.accKotaKode).change();
                        } else {
                            $('#accKotaKodeContainerEdit').addClass('d-none');
                            $('#accKcmKodeContainerEdit').addClass('d-none');
                            $('#accDesaContainerEdit').addClass('d-none');
                        }
                        // tampilkan modal edit
                        $('#bs-example-modal-lg-edit').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching akun data:', error);
                    }
                });
            };

            // pengaturan memilih memunculkan inputan sesuai kebutuhan role
            // jika role adalah PPL, maka akan muncul inputan untuk desa, kecamatan, Kota
            // jika role adalah BPP, maka akan muncul inputan untuk Kota
            // jika role adalah KAB, maka tidak akan muncul inputan apapun
            // jika ganti role, maka inputan yang tidak sesuai akan disembunyikan dan isinya akan
            // dihapus
            // inputan yang disembunyikan, keterangan required dihapus
            $('#accRole').change(function () {
                var role = $(this).val();
                if (role === 'PPL') {
                    $('#accKotaKodeContainer').removeClass('d-none');
                    $('#accKcmKodeContainer').removeClass('d-none');
                    $('#accDesaContainer').removeClass('d-none');
                    $('#accKotaKode').attr('required', true);
                    $('#accKcmKode').attr('required', true);
                    $('#accDesa').attr('required', true);
                } else if (role === 'BPP') {
                    $('#accKotaKodeContainer').removeClass('d-none');
                    $('#accKcmKodeContainer').addClass('d-none');
                    $('#accDesaContainer').addClass('d-none');
                    $('#accKotaKode').attr('required', true);
                    $('#accKcmKode').removeAttr('required');
                    $('#accDesa').removeAttr('required');
                } else if (role === 'KAB') {
                    $('#accKotaKodeContainer').addClass('d-none');
                    $('#accKcmKodeContainer').addClass('d-none');
                    $('#accDesaContainer').addClass('d-none');
                    $('#accKotaKode').removeAttr('required');
                    $('#accKcmKode').removeAttr('required');
                    $('#accDesa').removeAttr('required');
                } else {
                    $('#accKotaKodeContainer').addClass('d-none');
                    $('#accKcmKodeContainer').addClass('d-none');
                    $('#accDesaContainer').addClass('d-none');
                    $('#accKotaKode').removeAttr('required');
                    $('#accKcmKode').removeAttr('required');
                    $('#accDesa').removeAttr('required');
                }
            });

            // fungsi ganti role untuk modal edit, sama seperti tambah
            $('#accRoleEdit').change(function () {
                var role = $(this).val();
                if (role === 'PPL') {
                    $('#accKotaKodeContainerEdit').removeClass('d-none');
                    $('#accKcmKodeContainerEdit').removeClass('d-none');
                    $('#accDesaContainerEdit').removeClass('d-none');
                    $('#accKotaKodeEdit').attr('required', true);
                    $('#accKcmKodeEdit').attr('required', true);
                    $('#accDesaEdit').attr('required', true);
                } else if (role === 'BPP') {
                    $('#accKotaKodeContainerEdit').removeClass('d-none');
                    $('#accKcmKodeContainerEdit').addClass('d-none');
                    $('#accDesaContainerEdit').addClass('d-none');
                    $('#accKotaKodeEdit').attr('required', true);
                    $('#accKcmKodeEdit').removeAttr('required');
                    $('#accDesaEdit').removeAttr('required');
                } else if (role === 'KAB') {
                    $('#accKotaKodeContainerEdit').addClass('d-none');
                    $('#accKcmKodeContainerEdit').addClass('d-none');
                    $('#accDesaContainerEdit').addClass('d-none');
                    $('#accKotaKodeEdit').removeAttr('required');
                    $('#accKcmKodeEdit').removeAttr('required');
                    $('#accDesaEdit').removeAttr('required');
                } else {
                    $('#accKotaKodeContainerEdit').addClass('d-none');
                    $('#accKcmKodeContainerEdit').addClass('d-none');
                    $('#accDesaContainerEdit').addClass('d-none');
                    $('#accKotaKodeEdit').removeAttr('required');
                    $('#accKcmKodeEdit').removeAttr('required');
                    $('#accDesaEdit').removeAttr('required');
                }
            });

            // pengaturan untuk menampilkan dropdown kecamatan berdasarkan kota yang dipilih
            // jika kota belum dipilih, maka dropdown kecamatan tidak akan muncul
            // jika kota yang dipilih tidak memliki kecamatan, maka dropdown kecamatan tidak akan muncul
            $('#accKotaKode').change(function () {
                var kotaKode = $(this).val();
                var role = $('#accRole').val();
                if (kotaKode) {
                    $.ajax({
                        url: '<?= base_url('dashboard/get_kecamatan_by_kota') ?>',
                        type: 'POST',
                        data: { kotaKode: kotaKode },
                        dataType: 'json',
                        success: function (data) {
                            var options = '<option value="" disabled selected>Pilih Kecamatan</option>';
                            if (data.length > 0) {
                                $.each(data, function (index, item) {
                                    options += '<option value="' + item.kcmKode + '">' + item.kcmNama + '</option>';
                                });
                                $('#accKcmKodeContainer').removeClass('d-none');
                            } else {
                                $('#accKcmKodeContainer').addClass('d-none');
                            }
                            $('#accKcmKode').html(options);
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching kecamatan:', error);
                            $('#accKcmKodeContainer').addClass('d-none');
                        }
                    });
                } else {
                    $('#accKcmKodeContainer').addClass('d-none');
                }
            });

            // bikin fungsi untuk mengisi dropdown kecamatan berdasarkan kota yang dipilih untuk modal edit, sama seperti tambah
            $('#accKotaKodeEdit').change(function () {
                var kotaKode = $(this).val();
                var role = $('#accRoleEdit').val();
                if (kotaKode && role === 'PPL') {
                    $.ajax({
                        url: '<?= base_url('dashboard/get_kecamatan_by_kota') ?>',
                        type: 'POST',
                        data: { kotaKode: kotaKode },
                        dataType: 'json',
                        success: function (data) {
                            var options = '<option value="" disabled selected>Pilih Kecamatan</option>';
                            if (data.length > 0) {
                                $.each(data, function (index, item) {
                                    options += '<option value="' + item.kcmKode + '">' + item.kcmNama + '</option>';
                                });
                                $('#accKcmKodeContainerEdit').removeClass('d-none');
                            } else {
                                $('#accKcmKodeContainerEdit').addClass('d-none');
                            }
                            $('#accKcmKodeEdit').html(options);
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching kecamatan:', error);
                            $('#accKcmKodeContainerEdit').addClass('d-none');
                        }
                    });
                } else {
                    $('#accKcmKodeContainerEdit').addClass('d-none');
                }
            });

            // fungsi hapus data berdasarkan username
            window.setModalHapus = function (element) {
                var username = element.data('id');
                Swal.fire({
                    title: 'Hapus Akun',
                    text: "Apakah Anda yakin ingin menghapus akun ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('dashboard/hapus_akun') ?>',
                            type: 'POST',
                            data: { accUsername: username },
                            success: function (response) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Akun telah dihapus.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    'Gagal!',
                                    'Akun gagal dihapus.',
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