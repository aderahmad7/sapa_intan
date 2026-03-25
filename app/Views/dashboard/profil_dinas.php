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
                                
                                <form action="<?= base_url('dashboard/update_profildinas') ?>" method="post"
                                    enctype="multipart/form-data">

                                    <!-- Dibiarkan tersembunyi -->
                                    <div class="mb-3 d-none">
                                        <label for="accUsername" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="insKode" name="insKode"
                                            value="<?= esc($profil['insKode']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accRole" class="form-label">Nama Dinas</label>
                                        <input type="text" class="form-control" id="insNamaLengkap" name="insNamaLengkap"
                                            value="<?= esc($profil['insNamaLengkap']) ?>" disabled>
                                    </div>
                                    

                                    <!-- Informasi Pribadi -->
                                    <h5 class="mt-5 fw-bold fs-4">Data Kepala Dinas</h5>
                                    <div class="mb-3">
                                        <label for="accName" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="insKepalaNama" name="insKepalaNama"
                                            value="<?= esc($profil['insKepalaNama']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accNoWhatsapp" class="form-label">NIP</label>
                                        <input type="text" class="form-control" id="insKepalaNip" name="insKepalaNip"
                                            value="<?= esc($profil['insKepalaNip']) ?>" required>
                                    </div>
                                    <h5 class="mt-5 fw-bold fs-4">Data Kepala Bidang PSP</h5>
                                    <div class="mb-3">
                                        <label for="accName" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="insKabidNama" name="insKabidNama"
                                            value="<?= esc($profil['insKabidNama']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="accNoWhatsapp" class="form-label">NIP</label>
                                        <input type="text" class="form-control" id="insKabidNip" name="insKabidNip"
                                            value="<?= esc($profil['insKabidNip']) ?>" required>
                                    </div>
                                    <!-- Detail Profil Per Role -->
                                    <?php if ($user['role'] === 'BPP'): ?>
                                        <h5 class="mt-5 fw-bold fs-4">Data Kepala Balai BPP</h5>
                                        <div class="mb-3 d-none">
                                            <label for="accName" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="insBppNama" name="insBppNama"
                                                value="<?= esc($profil['insBppNama']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="accNoWhatsapp" class="form-label">NIP</label>
                                            <input type="text" class="form-control" id="insBppNip" name="insBppNip"
                                                value="<?= esc($profil['insBppNip']) ?>" required>
                                        </div>
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