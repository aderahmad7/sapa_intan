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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <form action="<?= base_url('dashboard/update_profil') ?>" method="post"
                                    enctype="multipart/form-data">

                                    <!-- Dibiarkan tersembunyi -->
                                    <div class="mb-3 d-none">
                                        <label for="accUsername" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="accUsername" name="accUsername"
                                            value="<?= esc($user['username']) ?>" required>
                                    </div>
                                    <div class="mb-3 d-none">
                                        <label for="accRole" class="form-label">Role</label>
                                        <input type="text" class="form-control" id="accRole" name="accRole"
                                            value="<?= esc($user['role']) ?>" readonly>
                                    </div>
                                    <div class="mb-3 d-none">
                                        <label for="accKcmKode" class="form-label">Kode Kecamatan</label>
                                        <input type="text" class="form-control" id="accKcmKode" name="accKcmKode"
                                            value="<?= esc($user['kcmKode']) ?>" readonly>
                                    </div>
                                    <div class="mb-3 d-none">
                                        <label for="accInsKode" class="form-label">Kode Instansi</label>
                                        <input type="text" class="form-control" id="accInsKode" name="accInsKode"
                                            value="<?= esc($user['insKode']) ?>" readonly>
                                    </div>

                                    <!-- Informasi Pribadi -->
                                    <h5 class="mt-5 fw-bold fs-4  d-none">Data Pribadi</h5>
                                    <div class="mb-3 d-none">
                                        <label for="accName" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="accName" name="accName"
                                            value="<?= esc($user['nama']) ?>" required>
                                    </div>
                                    <div class="mb-3 d-none">
                                        <label for="accNoWhatsapp" class="form-label">Nomor WhatsApp</label>
                                        <input type="text" class="form-control" id="accNoWhatsapp" name="accNoWhatsapp"
                                            value="<?= esc($user['noWhatsapp']) ?>" required>
                                    </div>
                                    <!-- Detail Profil Per Role -->
                                    <?php if ($user['role'] === 'PPL'): ?>
                                        <h5 class="mt-5 fw-bold fs-4">Data Kelompok Tani</h5>
                                        <div class="mb-3">
                                            <label for="proPplNama" class="form-label">Nama Kelompok</label>
                                            <input type="text" class="form-control" id="proPplNama" name="proPplNama"
                                                value="<?= esc($user['profil']['proPplNama']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="proPplNamaKetua" class="form-label">Nama Ketua Kelompok</label>
                                            <input type="text" class="form-control" id="proPplNamaKetua"
                                                name="proPplNamaKetua"
                                                value="<?= esc($user['profil']['proPplNamaKetua']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="proPplFileKTP" class="form-label">File KTP</label>
                                            <input type="file" class="form-control" id="proPplFileKTP" name="proPplFileKTP"
                                                accept=".jpg, .jpeg, .png">
                                            <?php if (!empty($user['profil']['proPplFileKTP'])): ?>
                                                <a href="<?= $user['profil']['proPplFileKTP'] ?>" target="_blank"
                                                    class="btn btn-info mt-2">Lihat KTP</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="proPplTelp" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="proPplTelp" name="proPplTelp"
                                                value="<?= esc($user['profil']['proPplTelp']) ?>">
                                        </div>
                                        <input type="hidden" name="proPplKcmKode"
                                            value="<?= esc($user['profil']['proPplKcmKode']) ?>">
                                        <input type="hidden" name="proPplDesa"
                                            value="<?= esc($user['profil']['proPplDesa']) ?>">
                                        <h5 class="mt-5 fw-bold fs-4">Informasi Penyuluh</h5>
                                    
                                        <div class="mb-3">
                                            <label for="proPplPenyuluhNama" class="form-label">Nama Penyuluh</label>
                                            <input type="text" class="form-control" id="proPplPenyuluhNama"
                                                name="proPplPenyuluhNama"
                                                value="<?= esc($user['profil']['proPplPenyuluhNama']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="proPplPenyuluhTelp" class="form-label">Nomor Telepon
                                                Penyuluh</label>
                                            <input type="text" class="form-control" id="proPplPenyuluhTelp"
                                                name="proPplPenyuluhTelp"
                                                value="<?= esc($user['profil']['proPplPenyuluhTelp']) ?>">
                                        </div>
                                    <?php endif; ?>
                                    <!-- Informasi Wilayah / Instansi (Readonly) -->
                                    <h5 class="mt-5 fw-bold fs-4">Informasi Wilayah & Instansi</h5>
                                    <?php if ($user['role'] === 'PPL'): ?>
                                        <div class="mb-3">
                                            <label for="accKabupaten" class="form-label">Kabupaten/Kota</label>
                                            <input type="text" class="form-control" id="accKabupaten"
                                                value="<?= esc($kcmKota['kotaNama']) ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="accKcm" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" id="accKcm"
                                                value="<?= esc($kcmKota['kcmNama']) ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="accDesa" class="form-label">Desa</label>
                                            <input type="text" class="form-control" id="accDesa" name="accDesa"
                                                value="<?= esc($user['desa']) ?>" disabled>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($user['role'] === 'BPP'): ?>
                                        <div class="mb-3">
                                            <label for="accKotaKode" class="form-label">Kode Kota</label>
                                            <input type="text" class="form-control" id="accKotaKode" name="accKotaKode"
                                                value="<?= esc($user['kotaKode']) ?>" disabled>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mb-3">
                                        <label for="accKcm" class="form-label">Instansi</label>
                                        <input type="text" class="form-control" id="accKcm"
                                            value="<?= esc($instansi) ?>" disabled>
                                    </div>

                                    <!-- Data Profil Tersembunyi -->
                                    <input type="hidden" name="proTipeUsul"
                                        value="<?= esc($user['profil']['proTipeUsul']) ?>">
                                    <input type="hidden" name="proUsername"
                                        value="<?= esc($user['profil']['proUsername']) ?>">
                                    <?php if ($user['role'] === 'PPL' || $user['role'] === 'KAB'): ?>
                                        <input type="hidden" name="proInsKode"
                                            value="<?= esc($user['profil']['proInsKode']) ?>">
                                    <?php endif; ?>

                                    

                                    <?php if ($user['role'] === 'KAB'): ?>
                                        <h5 class="mt-5 fw-bold fs-4">Data Pengusul</h5>
                                        <div class="mb-3">
                                            <label for="proKabNamaLengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="proKabNamaLengkap"
                                                name="proKabNamaLengkap"
                                                value="<?= esc($user['profil']['proKabNamaLengkap']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="proKabTelp" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="proKabTelp" name="proKabTelp"
                                                value="<?= esc($user['profil']['proKabTelp']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="proKabJabatan" class="form-label">Jabatan</label>
                                            <input type="text" class="form-control" id="proKabJabatan" name="proKabJabatan"
                                                value="<?= esc($user['profil']['proKabJabatan']) ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="proKabFileTTd" class="form-label">File Tanda Tangan</label>
                                            <input type="file" class="form-control" id="proKabFileTTd" name="proKabFileTTd"
                                                accept=".jpg, .jpeg, .png">
                                            <?php if (!empty($user['profil']['proKabFileTTd'])): ?>
                                                <a href="<?= $user['profil']['proKabFileTTd'] ?>" target="_blank"
                                                    class="btn btn-info mt-2">Lihat Tanda Tangan</a>
                                            <?php endif; ?>
                                        </div>
                                        <input type="hidden" name="proKabKotaKode"
                                            value="<?= esc($user['profil']['proKabKotaKode']) ?>">
                                    <?php endif; ?>

                                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    <script>
        $(document).ready(function () {

        });
    </script>
</body>

</html>