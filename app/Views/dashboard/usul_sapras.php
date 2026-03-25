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
                <?php if ($user['role'] == 'PPL'): ?>
                    <!-- Tombol Tambah -->
                    <div class="mb-3">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg"
                            class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Data
                        </button>
                    </div>
                <?php endif; ?>
                <?php if ($user['role'] == 'PROV' || $user['role'] == 'KAB'): ?>
                    <!-- Tombol Tambah -->
                    <div class="mb-3">

                        <div class="btn-group" role="group" aria-label="Basic example">
                            <?php if ($user['role'] == 'KAB'): ?>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg"
                                    class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                            <?php endif; ?>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#modalFilter"
                                class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                        </div>
                    </div>
                <?php endif; ?>
                <table id="myTable" class="display table border table-striped table-bordered text-nowrap">
                    <thead>
                        <tr>

                            <th>No</th>
                            <th>Pengusul</th>
                            <th>Tipe</th>
                            <th>Kondisi</th>
                            <th>Kepemilikan</th>
                            <th>Status</th>
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
                                <form action="<?= base_url('dashboard/add_sapras') ?>" method="post"
                                    enctype="multipart/form-data">
                                    <!-- Input usulUsername hidden -->
                                    <input type="hidden" name="usulUsername" id="usulUsername"
                                        value="<?= $user['username'] ?>">
                                    <!-- Input kalKode (dropdown) -->
                                    <div class="mb-3">
                                        <label for="kalKode" class="form-label">Kategori</label>
                                        <select class="form-select" id="kalKode" name="kalKode" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <?php foreach ($kategori as $kat): ?>
                                                <option value="<?= $kat['kalKode'] ?>"><?= $kat['kalNama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- Input usulTipeKode (dropdown) -->
                                    <div class="mb-3">
                                        <label for="usulTipeKode" class="form-label">Tipe Kode</label>
                                        <select class="form-select" id="usulTipeKode" name="usulTipeKode" required>
                                            <option value="" disabled selected>Pilih Tipe Kode</option>
                                        </select>
                                    </div>
                                    <!-- Input usulNoMesin -->
                                    <div class="mb-3">
                                        <label for="usulNoMesin" class="form-label">Nomor Mesin</label>
                                        <input type="text" class="form-control" id="usulNoMesin" name="usulNoMesin"
                                            required>
                                    </div>
                                    <!-- Input usulNoRangka -->
                                    <div class="mb-3">
                                        <label for="usulNoRangka" class="form-label">Nomor Rangka</label>
                                        <input type="text" class="form-control" id="usulNoRangka" name="usulNoRangka"
                                            required>
                                    </div>
                                    <!-- Input usulKomoditi -->
                                    <div class="mb-3">
                                        <label for="usulKomoditi" class="form-label">Komoditi</label>
                                        <input type="text" class="form-control" id="usulKomoditi" name="usulKomoditi"
                                            required>
                                    </div>
                                    <!-- Input usulKonKode (kondisi) dropdown -->
                                    <div class="mb-3">
                                        <label for="usulKonKode" class="form-label">Kondisi</label>
                                        <select class="form-select" id="usulKonKode" name="usulKonKode" required>
                                            <option value="" disabled selected>Pilih Kondisi</option>
                                            <option value="Baik">Baik</option>
                                            <option value="Rusak Ringan">Rusak Ringan</option>
                                            <option value="Rusak Sedang">Rusak Sedang</option>
                                            <option value="Rusak Berat">Rusak Berat</option>
                                        </select>
                                    </div>
                                    <!-- Input usulKepemilikan dropdown -->
                                    <div class="mb-3">
                                        <label for="usulKepemilikan" class="form-label">Kepemilikan</label>
                                        <select class="form-select" id="usulKepemilikan" name="usulKepemilikan"
                                            required>
                                            <option value="" disabled selected>Pilih Kepemilikan</option>
                                            <option value="Milik Sendiri">Milik Sendiri</option>
                                            <option value="Pinjam Pakai">Pinjam Pakai</option>
                                            <option value="Sewa">Sewa</option>
                                        </select>
                                    </div>
                                    <!-- Input usulLuasKinerja -->
                                    <div class="mb-3">
                                        <label for="usulLuasKinerja" class="form-label">Luas Kinerja</label>
                                        <input type="number" class="form-control" id="usulLuasKinerja"
                                            name="usulLuasKinerja" required>
                                    </div>
                                    <!-- Input usulKoordinat -->
                                    <div class="mb-3">
                                        <label for="usulKoordinat" class="form-label">Koordinat</label>
                                        <input type="text" class="form-control" id="usulKoordinat" name="usulKoordinat"
                                            required>
                                    </div>
                                    <!-- Input usulLuasJam -->
                                    <div class="mb-3">
                                        <label for="usulLuasJam" class="form-label">Luas Jam</label>
                                        <input type="number" class="form-control" id="usulLuasJam" name="usulLuasJam"
                                            required>
                                    </div>
                                    <?php if ($user['role'] == 'PPL' || $user['role'] == 'KAB'): ?>
                                        <!-- Input kelompok tani (dropdown) -->
                                        <div class="mb-3">
                                            <label for="usulPokKode" class="form-label">Kelompok Tani</label>
                                            <select class="form-select" id="usulPokKode" name="usulPokKode" required>
                                                <option value="" disabled selected>Pilih Kelompok Tani</option>
                                                <?php foreach ($poktanList as $kt): ?>
                                                    <option value="<?= $kt['pokKode'] ?>"><?= $kt['pokPplNama'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($user['role'] == 'PPL' || $user['role'] == 'KAB' || $user['role'] == 'PROV'): ?>
                                        <!-- Input usulFoto1 (file) -->
                                        <div class="mb-3">
                                            <label for="usulFoto1" class="form-label">Foto 1</label>
                                            <input type="file" class="form-control" id="usulFoto1" name="usulFoto1"
                                                accept="image/*" required>
                                        </div>
                                        <!-- Input usulFoto2 (file) -->
                                        <div class="mb-3">
                                            <label for="usulFoto2" class="form-label">Foto 2</label>
                                            <input type="file" class="form-control" id="usulFoto2" name="usulFoto2"
                                                accept="image/*" required>
                                        </div>
                                        <!-- Input usulFoto3 (file) -->
                                        <div class="mb-3">
                                            <label for="usulFoto3" class="form-label">Foto 3</label>
                                            <input type="file" class="form-control" id="usulFoto3" name="usulFoto3"
                                                accept="image/*" required>
                                        </div>
                                        <!-- Input usulFoto4 (file) -->
                                        <div class="mb-3">
                                            <label for="usulFoto4" class="form-label">Foto 4</label>
                                            <input type="file" class="form-control" id="usulFoto4" name="usulFoto4"
                                                accept="image/*" required>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Input usulInsKode (instansi) hidden -->
                                    <input type="hidden" name="usulInsKode" value="<?= $user['insKode'] ?>">
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
                                    <!-- Input kalKode (dropdown) -->
                                    <div class="mb-3">
                                        <label for="kalKodeEdit" class="form-label">Kategori</label>
                                        <select class="form-select" id="kalKodeEdit" name="kalKodeEdit" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <?php foreach ($kategori as $kat): ?>
                                                <option value="<?= $kat['kalKode'] ?>"><?= $kat['kalNama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- Input usulTipeKode (dropdown) -->
                                    <div class="mb-3">
                                        <label for="usulTipeKodeEdit" class="form-label">Tipe Kode</label>
                                        <select class="form-select" id="usulTipeKodeEdit" name="usulTipeKodeEdit"
                                            required>
                                            <option value="" disabled selected>Pilih Tipe Kode</option>
                                        </select>
                                    </div>
                                    <!-- Input usulNoMesin -->
                                    <div class="mb-3">
                                        <label for="usulNoMesinEdit" class="form-label">Nomor Mesin</label>
                                        <input type="text" class="form-control" id="usulNoMesinEdit"
                                            name="usulNoMesinEdit" required>
                                    </div>
                                    <!-- Input usulNoRangka -->
                                    <div class="mb-3">
                                        <label for="usulNoRangkaEdit" class="form-label">Nomor Rangka</label>
                                        <input type="text" class="form-control" id="usulNoRangkaEdit"
                                            name="usulNoRangkaEdit" required>
                                    </div>
                                    <!-- Input usulKomoditi -->
                                    <div class="mb-3">
                                        <label for="usulKomoditiEdit" class="form-label">Komoditi</label>
                                        <input type="text" class="form-control" id="usulKomoditiEdit"
                                            name="usulKomoditiEdit" required>
                                    </div>
                                    <!-- Input usulKonKode (kondisi) dropdown -->
                                    <div class="mb-3">
                                        <label for="usulKonKodeEdit" class="form-label">Kondisi</label>
                                        <select class="form-select" id="usulKonKodeEdit" name="usulKonKodeEdit"
                                            required>
                                            <option value="" disabled selected>Pilih Kondisi</option>
                                            <option value="Baik">Baik</option>
                                            <option value="Rusak Ringan">Rusak Ringan</option>
                                            <option value="Rusak Sedang">Rusak Sedang</option>
                                            <option value="Rusak Berat">Rusak Berat</option>
                                        </select>
                                    </div>
                                    <!-- Input usulKepemilikan dropdown -->
                                    <div class="mb-3">
                                        <label for="usulKepemilikanEdit" class="form-label">Kepemilikan</label>
                                        <select class="form-select" id="usulKepemilikanEdit" name="usulKepemilikanEdit"
                                            required>
                                            <option value="" disabled selected>Pilih Kepemilikan</option>
                                            <option value="Milik Sendiri">Milik Sendiri</option>
                                            <option value="Pinjam Pakai">Pinjam Pakai</option>
                                            <option value="Sewa">Sewa</option>
                                        </select>
                                    </div>
                                    <!-- Input usulLuasKinerja -->
                                    <div class="mb-3">
                                        <label for="usulLuasKinerjaEdit" class="form-label">Luas Kinerja</label>
                                        <input type="number" class="form-control" id="usulLuasKinerjaEdit"
                                            name="usulLuasKinerjaEdit" required>
                                    </div>
                                    <!-- Input usulKoordinat -->
                                    <div class="mb-3">
                                        <label for="usulKoordinatEdit" class="form-label">Koordinat</label>
                                        <input type="text" class="form-control" id="usulKoordinatEdit"
                                            name="usulKoordinatEdit" required>
                                    </div>
                                    <!-- Input usulLuasJam -->
                                    <div class="mb-3">
                                        <label for="usulLuasJamEdit" class="form-label">Luas Jam</label>
                                        <input type="number" class="form-control" id="usulLuasJamEdit"
                                            name="usulLuasJamEdit" required>
                                    </div>
                                    <?php if ($user['role'] == 'PPL' || $user['role'] == 'PROV'): ?>
                                        <!-- Input usulFoto1 (file) -->
                                        <div class="mb-3">
                                            <label for="usulFoto1Edit" class="form-label">Foto 1</label>
                                            <input type="file" class="form-control" id="usulFoto1Edit" name="usulFoto1Edit"
                                                accept="image/*">
                                            <a id="linkFoto1" href="<?= esc(base_url()) ?>" target="_blank"
                                                class="btn btn-info mt-2 d-none">Lihat Foto 1</a>
                                        </div>
                                        <!-- Input usulFoto2 (file) -->
                                        <div class="mb-3">
                                            <label for="usulFoto2Edit" class="form-label">Foto 2</label>
                                            <input type="file" class="form-control" id="usulFoto2Edit" name="usulFoto2Edit"
                                                accept="image/*">
                                            <a id="linkFoto2" href="<?= esc(base_url()) ?>" target="_blank"
                                                class="btn btn-info mt-2 d-none">Lihat Foto 2</a>
                                        </div>
                                        <!-- Input usulFoto3 (file) -->
                                        <div class="mb-3">
                                            <label for="usulFoto3Edit" class="form-label">Foto 3</label>
                                            <input type="file" class="form-control" id="usulFoto3Edit" name="usulFoto3Edit"
                                                accept="image/*">
                                            <a id="linkFoto3" href="<?= esc(base_url()) ?>" target="_blank"
                                                class="btn btn-info mt-2 d-none">Lihat Foto 3</a>
                                        </div>
                                        <!-- Input usulFoto4 (file) -->
                                        <div class="mb-3">
                                            <label for="usulFoto4Edit" class="form-label">Foto 4</label>
                                            <input type="file" class="form-control" id="usulFoto4Edit" name="usulFoto4Edit"
                                                accept="image/*">
                                            <a id="linkFoto4" href="<?= esc(base_url()) ?>" target="_blank"
                                                class="btn btn-info mt-2 d-none">Lihat Foto 4</a>
                                        </div>
                                    <?php endif; ?>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

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
                                    <!-- Koordinat -->
                                    <div class="mb-3">
                                        <label for="usulKoordinatLihat" class="form-label">Koordinat</label>
                                        <input type="text" class="form-control" id="usulKoordinatLihat" disabled>
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

                <!-- Modal Lihat Komentar -->
                <div class="modal fade" id="modalLihatKomentar" tabindex="-1" role="dialog"
                    aria-labelledby="modalLihatKomentarLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modalLihatKomentarLabel">Lihat Komentar</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('dashboard/add_feedback') ?>" method="post">
                                    <!-- Hidden input usulKode -->
                                    <input type="hidden" name="usulKodeKomentar" id="usulKodeKomentarLihat">

                                    <!-- Komentar dan feedback akan dimasukkan lewat JavaScript -->
                                    <div id="containerKomentar"></div>

                                    <!-- Tombol submit hanya tampil jika ada input feedback -->
                                    <div id="submitFeedbackWrapper" class="mt-3 d-none">
                                        <button type="submit" class="btn btn-primary">Kirim Feedback</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Tambah Komentar -->
                <div class="modal fade" id="modalKomentar" tabindex="-1" role="dialog"
                    aria-labelledby="modalKomentarLabel" aria-hidden="true" data-bs-backdrop="static"
                    data-bs-keyboard="false">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modalKomentarLabel">Tambah Komentar</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('dashboard/add_komentar') ?>" method="post">
                                    <!-- Input hidden usulKode -->
                                    <input type="hidden" name="usulKodeKomentar" id="usulKodeKomentar">

                                    <?php if ($user['role'] == 'BPP'): ?>
                                        <!-- Komentar BPP -->
                                        <div class="mb-3">
                                            <label for="usulCatatanBPP" class="form-label">Catatan BPP</label>
                                            <textarea class="form-control" id="usulCatatanBPP" name="usulCatatanBPP"
                                                rows="4" required></textarea>
                                        </div>
                                    <?php elseif ($user['role'] == 'KAB'): ?>
                                        <!-- Komentar KAB -->
                                        <div class="mb-3">
                                            <label for="usulCatatanKab" class="form-label">Catatan Kabupaten</label>
                                            <textarea class="form-control" id="usulCatatanKab" name="usulCatatanKab"
                                                rows="4" required></textarea>
                                        </div>
                                    <?php elseif ($user['role'] == 'PROV'): ?>
                                        <!-- Komentar PROV -->
                                        <div class="mb-3">
                                            <label for="usulCatatanProv" class="form-label">Catatan Provinsi</label>
                                            <textarea class="form-control" id="usulCatatanProv" name="usulCatatanProv"
                                                rows="4" required></textarea>
                                        </div>
                                    <?php endif; ?>

                                    <button type="submit" class="btn btn-primary">Simpan Komentar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Komentar -->
            <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalKomentarLabel"
                aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalKomentarLabel">Filter</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" id="form_filter">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" id="usulStatus_filter" name="usulStatus_filter"
                                        required>
                                        <option value="" selected>Pilih Semua</option>
                                        <?php if ($user['role'] == 'KAB'): ?>
                                            <option value="2">Baru</option>
                                            <option value="4">Diterima</option>
                                            <option value="5">Ditolak</option>
                                        <?php elseif ($user['role'] == 'PROV'): ?>
                                            <option value="4">Baru</option>
                                            <option value="6">Diterima</option>
                                            <option value="7">Ditolak</option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Usulan</label>
                                    <select class="form-select" id="proTipeUsul_filter" name="proTipeUsul_filter"
                                        required>
                                        <option value="" selected>Pilih Semua</option>
                                        <option value="PPL">Dari PPL</option>
                                        <option value="KAB">Dari DINAS</option>
                                    </select>
                                </div>
                                <?php if ($user['role'] == 'PROV'): ?>
                                    <div class="mb-3">
                                        <label for="accInsKode_filter" class="form-label">Instansi</label>
                                        <select class="form-select" id="accInsKode_filter" name="accInsKode_filter"
                                            required>
                                            <option value="" selected>Pilih Instansi</option>
                                            <?php foreach ($instansiList as $instansi): ?>
                                                <option value="<?= $instansi['insKode'] ?>">
                                                    <?= $instansi['insNamaLengkap'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label class="form-label">Kabupaten/Kota</label>
                                    <select class="form-select" id="accKotaKode_filter" name="accKotaKode_filter">
                                        <option value="" selected>Pilih Semua</option>

                                        <?php foreach ($kabupaten as $kab): ?>
                                            <?php if ($user['role'] == 'KAB'): ?>
                                                <?php if ($user['kotaKode'] == $kab['kotaKode']): ?>
                                                    <option value="<?= $kab['kotaKode'] ?>"><?= $kab['kotaNama'] ?></option>
                                                <?php endif; ?>
                                            <?php elseif ($user['role'] == 'PRVO'): ?>
                                                <option value="<?= $kab['kotaKode'] ?>"><?= $kab['kotaNama'] ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="accKcmKode" class="form-label">Kecamatan</label>
                                    <select class="form-select" id="accKcmKode_filter" name="accKcmKode_filter">
                                        <option value="" disabled selected>Pilih Semua </option>
                                        <!-- Kecamatannya akan diisi melalui AJAX berdasarkan kota yang dipilih -->
                                        <!-- Contoh: <option value="kcm1">Kecamatan 1</option> -->
                                    </select>
                                </div>
                                <a href="#" class="btn btn-primary" id="btn-filter">Filter</a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-profil" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Profil Pengusul</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
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
                                <a id="linkFoto1Lihat" href="#" target="_blank" class="btn btn-info d-none">Lihat Foto
                                    1</a>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto 2</label><br>
                                <a id="linkFoto2Lihat" href="#" target="_blank" class="btn btn-info d-none">Lihat Foto
                                    2</a>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto 3</label><br>
                                <a id="linkFoto3Lihat" href="#" target="_blank" class="btn btn-info d-none">Lihat Foto
                                    3</a>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto 4</label><br>
                                <a id="linkFoto4Lihat" href="#" target="_blank" class="btn btn-info d-none">Lihat Foto
                                    4</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Profil Pengusul</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%">Jenis Pengusul</th>
                                        <td id="proTipeUsul"></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">Nama Kelompok Tani</th>
                                        <td id="proPplNama"></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">Nama Ketua Kelompok Tani</th>
                                        <td id="proPplNamaKetua"></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">Telp Ketua Kelompok Tani</th>
                                        <td id="proPplTelp"></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">KTP Ketua Kelompok Tani</th>
                                        <td> <a id="proPplFileKTP" href="#" target="_blank" class="btn btn-info">Lihat
                                                KTP</a></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">Desa</th>
                                        <td id="proPplDesa"></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">Kecamatan</th>
                                        <td id="kcmNama"></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">Kota</th>
                                        <td id="kotaNama"></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">Penyuluh</th>
                                        <td id="proPplPenyuluhNama"></td>
                                    </tr>
                                    <tr class="ppl_pengusul">
                                        <th width="30%">Telp. Penyuluh</th>
                                        <td id="proPplPenyuluhTelp"></td>
                                    </tr>
                                    <tr class="kab_pengusul">
                                        <th width="30%">Dinas</th>
                                        <td id="insNamaLengkap"></td>
                                    </tr>
                                    <tr class="kab_pengusul">
                                        <th width="30%">Nama Pengusul</th>
                                        <td id="proKabNamaLengkap"></td>
                                    </tr>
                                    <tr class="kab_pengusul">
                                        <th width="30%">Telp</th>
                                        <td id="proKabTelp"></td>
                                    </tr>
                                    <tr class="kab_pengusul">
                                        <th width="30%">Jabatan</th>
                                        <td id="proKabJabatan"></td>
                                    </tr>
                                    <!-- Tambahkan baris lainnya sesuai kebutuhan -->
                                </tbody>
                            </table>
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
        function getProfil(id) {
            $.ajax({
                url: '<?= base_url('dashboard/profil_pengusul/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (tipeData) {
                    console.log(tipeData.data)
                    console.log("kelompok: " + tipeData.data.poktan.pokPPlNama);
                    $('#detailModal').modal('show');
                    if (tipeData.data.proTipeUsul == "PPL") {
                        $(".ppl_pengusul").show();
                        $(".kab_pengusul").hide();
                    } else {
                        $(".ppl_pengusul").hide();
                        $(".kab_pengusul").show();
                    }
                    var url = '<?= base_url('uploads/') ?>';
                    var foto1 = `${url}/${tipeData.data.poktan.pokPPlFileKTP}`;

                    $('#proTipeUsul').html(tipeData.data.proTipeUsul);
                    $('#proPplNama').html(tipeData.data.poktan.pokPplNama);
                    $('#proPplNamaKetua').html(tipeData.data.poktan.pokPplNamaKetua);
                    $('#proPplTelp').html(tipeData.data.poktan.pokPplTelp);
                    $('#proPplFileKTP').attr('href', foto1);
                    $('#proPplDesa').html(tipeData.data.proPplDesa);
                    $('#kcmNama').html(tipeData.data.kcmNama);
                    $('#kotaNama').html(tipeData.data.kotaNama);
                    $('#proPplPenyuluhNama').html(tipeData.data.proPplPenyuluhNama);
                    $('#proPplPenyuluhTelp').html(tipeData.data.proPplPenyuluhTelp);
                    $('#insNamaLengkap').html(tipeData.data.insNamaLengkap);
                    $('#proKabNamaLengkap').html(tipeData.data.proKabNamaLengkap);
                    $('#proKabTelp').html(tipeData.data.proKabTelp);
                    $('#proKabJabatan').html(tipeData.data.proKabJabatan);

                }
            })
        }
        $(document).ready(function () {
            oTable = $('#myTable').DataTable({
                ajax: {
                    url: '<?php echo base_url(); ?>dashboard/datatable',
                    data: function (d) {
                        d.filter = $('#form_filter').serializeArray();
                    }
                },
                processing: true,
                serverSide: true,
                order: [[0, 'desc']],
                columns: [

                    {
                        data: 'usulKode',
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
                            var detail = "<br> <a href='#' class='small' onclick='getProfil(" + row.usulKode + ")'><i class='fas fa-user'></i> Detail Pengusul</a>";
                            if (data == "KAB")
                                return data + "<br>" + row.proKabNamaLengkap + detail;
                            if (data == "PPL")
                                return data + "<br>" + row.proPplNama + detail;
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
                                if (status == 4 & row.accRole == "KAB") {
                                    label = 'Dikirim';
                                    badgeClass = 'bg-info';
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
                        data: 'usulKode', searchable: false, orderable: false,
                        render: function (data, type, row) {
                            var status = parseInt(row.usulStatus);
                            var role = "<?= $user['role'] ?>"; // Pastikan ini didefinisikan dari PHP ke JS

                            if (status === 0) {
                                var edit = '<a data-id="' + data + '" style="margin:0px 3px 0px 0px;" onclick="edit($(this));return false;" href="#" title="Ubah"><i class="fas fa-edit"></i></a>';
                                var hapus = '<a data-id="' + data + '" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-hapus" onclick="return setModalHapus($(this));" href="#" title="Hapus"><i class="fas fa-trash"></i></a>';
                                var kirim = '<a data-id="' + data + '" style="margin:0px 3px 0px 0px;" data-bs-backdrop="static" data-bs-toggle="modal" data-bs-target="#modal-kirim" onclick="return kirimUsul($(this));" href="#" title="Kirim Usul"><i class="fas fa-paper-plane"></i></a>';
                                return kirim + edit + hapus;
                            } else if (
                                (status === 1 && role === "BPP") ||
                                (status === 2 && role === "KAB") ||
                                (status === 4 && role === "PROV")
                            ) {
                                var lihat = '<a data-id="' + data + '" style="margin:0px 3px 0px 0px;" onclick="lihatData($(this));return false;" href="#" title="Lihat Data"><i class="fas fa-eye"></i></a>';
                                var terima = '<a data-id="' + data + '" style="margin:0px 5px 0px 0px;" onclick="terimaUsul($(this));return false;" href="#" title="Terima Usul"><i class="fas fa-check-circle text-success"></i></a>';
                                var tolak = '<a data-id="' + data + '" style="margin:0px 5px 0px 0px;" onclick="tolakUsul($(this));return false;" href="#" title="Tolak Usul"><i class="fas fa-times-circle text-danger"></i></a>';
                                return lihat + terima + tolak;
                            } else {
                                var lihat = '<a data-id="' + data + '" style="margin:0px 3px 0px 0px;" onclick="lihatData($(this));return false;" href="#" title="Lihat Data"><i class="fas fa-eye"></i></a>';
                                var komentar = '<a data-id="' + data + '" style="margin:0px 3px 0px 0px;" onclick="lihatKomentar($(this));return false;" href="#" title="Lihat Komentar"><i class="fas fa-comments"></i></a>';
                                return lihat + komentar;
                            }
                        }
                    }
                ]
            });





            window.edit = function (element) {
                var usulKode = element.data('id');
                var baseUrl = '<?= base_url('dashboard/edit_sapras') ?>';
                $.ajax({
                    url: '<?= base_url('dashboard/get_sapras_by_usulkode') ?>',
                    type: 'POST',
                    data: { usulKode: usulKode },
                    dataType: 'json',
                    success: function (data) {
                        // tambahkan username menjadi parameter di url form action jadi dashboard/edit_akun/${username}
                        var formAction = `${baseUrl}/${usulKode}`;
                        $('#bs-example-modal-lg-edit form').attr('action', formAction);
                        $('#kalKodeEdit').val(data.tipeKalKode).change(
                            $.ajax({
                                url: '<?= base_url('dashboard/get_tipe_kode') ?>',
                                type: 'POST',
                                data: { kalKode: data.tipeKalKode },
                                dataType: 'json',
                                success: function (tipeData) {
                                    var tipes = '<option value="" disabled selected>Pilih Tipe Kode</option>';
                                    $.each(tipeData, function (index, item) {
                                        tipes += '<option value="' + item.tipeKode + '">' + item.tipeNama + '</option>';
                                    });
                                    $('#usulTipeKodeEdit').html(tipes).val(data.usulTipeKode).change();
                                }
                            })
                        );
                        $('#usulNoMesinEdit').val(data.usulNoMesin);
                        $('#usulNoRangkaEdit').val(data.usulNoRangka);
                        $('#usulKomoditiEdit').val(data.usulKomoditi);
                        $('#usulKonKodeEdit').val(data.usulKonKode);
                        $('#usulKepemilikanEdit').val(data.usulKepemilikan);
                        $('#usulLuasKinerjaEdit').val(data.usulLuasKinerja);
                        $('#usulKoordinatEdit').val(data.usulKoordinat);
                        $('#usulLuasJamEdit').val(data.usulLuasJam);

                        var url = '<?= base_url('uploads/') ?>';
                        var foto1 = `${url}/${data.usulFoto1}`;
                        var foto2 = `${url}/${data.usulFoto2}`;
                        var foto3 = `${url}/${data.usulFoto3}`;
                        var foto4 = `${url}/${data.usulFoto4}`;
                        $('#linkFoto1').removeClass('d-none').attr('href', foto1);
                        $('#linkFoto2').removeClass('d-none').attr('href', foto2);
                        $('#linkFoto3').removeClass('d-none').attr('href', foto3);
                        $('#linkFoto4').removeClass('d-none').attr('href', foto4);
                        // tampilkan modal edit
                        $('#bs-example-modal-lg-edit').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching akun data:', error);
                    }
                });
            };

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
                        $('#usulKoordinatLihat').val(data.usulKoordinat);
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

            $('#btn-filter').click(function () {
                reloadDatatable();
            });

            function reloadDatatable() {
                oTable.ajax.reload(null, false);
            }

            $('#accKotaKode_filter').change(function () {
                var kotaKode = $(this).val();
                var role = $('#accRole').val();
                $.ajax({
                    url: '<?= base_url('dashboard/get_kecamatan_by_kota') ?>',
                    type: 'POST',
                    data: { kotaKode: kotaKode },
                    dataType: 'json',
                    success: function (data) {
                        var options = '<option value="">Pilih Semua</option>';
                        if (data.length > 0) {
                            $.each(data, function (index, item) {
                                options += '<option value="' + item.kcmKode + '">' + item.kcmNama + '</option>';
                            });

                        } else {

                        }
                        $('#accKcmKode_filter').html(options);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching kecamatan:', error);
                        $('#accKcmKodeContainer').addClass('d-none');
                    }
                });

            });

            // fungsi untuk mengisi dropdown usulTipeKode berdasarkan kalKode
            $('#kalKodeEdit').change(function () {
                var kalKode = $(this).val();
                $.ajax({
                    url: '<?= base_url('dashboard/get_tipe_kode') ?>',
                    type: 'POST',
                    data: { kalKode: kalKode },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        $('#usulTipeKodeEdit').empty();
                        $('#usulTipeKodeEdit').append('<option value="" disabled selected>Pilih Tipe Kode</option>');
                        $.each(data, function (index, item) {
                            $('#usulTipeKodeEdit').append('<option value="' + item.tipeKode + '">' + item.tipeNama + '</option>');
                        });
                    }
                });
            });

            // fungsi untuk mengisi dropdown usulTipeKode berdasarkan kalKode
            $('#kalKode').change(function () {
                var kalKode = $(this).val();
                $.ajax({
                    url: '<?= base_url('dashboard/get_tipe_kode') ?>',
                    type: 'POST',
                    data: { kalKode: kalKode },
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        $('#usulTipeKode').empty();
                        $('#usulTipeKode').append('<option value="" disabled selected>Pilih Tipe Kode</option>');
                        $.each(data, function (index, item) {
                            $('#usulTipeKode').append('<option value="' + item.tipeKode + '">' + item.tipeNama + '</option>');
                        });
                    }
                });
            });

            // fungsi hapus data berdasarkan username
            window.setModalHapus = function (element) {
                var usulKode = element.data('id');
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
                            url: '<?= base_url('dashboard/hapus_sapras') ?>',
                            type: 'POST',
                            data: { usulKode: usulKode },
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

            // fungsi hapus data berdasarkan username
            window.kirimUsul = function (element) {
                var usulKode = element.data('id');
                Swal.fire({
                    title: 'Kirim Usul',
                    text: "Apakah Anda yakin ingin mengirim usul ini ke BPP?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, kirim!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('dashboard/kirim_sapras') ?>',
                            type: 'POST',
                            data: { usulKode: usulKode },
                            success: function (response) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Usul telah terkirim ke BPP.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function (xhr, status, error) {
                                Swal.fire(
                                    'Gagal!',
                                    'Usul gagal terkirim ke BPP.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            };

            window.terimaUsul = function (element) {
                var usulKode = element.data('id');
                Swal.fire({
                    title: 'Terima Usul',
                    text: "Yakin ingin menerima usul ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, terima!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('dashboard/terima_usul') ?>',
                            type: 'POST',
                            data: { usulKode: usulKode },
                            success: function (response) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Usul berhasil diterima.',
                                    'success'
                                ).then(() => {
                                    // Set value dan tampilkan modal komentar
                                    $('#usulKodeKomentar').val(usulKode);
                                    $('#modalKomentar').modal('show');
                                    // Reload DataTable bisa ditaruh di modalKomentar submit nanti
                                });
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menerima usul.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            };

            window.tolakUsul = function (element) {
                var usulKode = element.data('id');
                Swal.fire({
                    title: 'Tolak Usul',
                    text: "Yakin ingin menolak usul ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, tolak!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('dashboard/tolak_usul') ?>',
                            type: 'POST',
                            data: { usulKode: usulKode },
                            success: function (response) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Usul berhasil ditolak.',
                                    'success'
                                ).then(() => {
                                    // Set value dan tampilkan modal komentar
                                    $('#usulKodeKomentar').val(usulKode);
                                    $('#modalKomentar').modal('show');
                                });
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menolak usul.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            };

            window.lihatKomentar = function (element) {
                var usulKode = element.data('id');
                $.ajax({
                    url: '<?= base_url('dashboard/get_sapras_by_usulkode') ?>',
                    type: 'POST',
                    data: { usulKode: usulKode },
                    dataType: 'json',
                    success: function (data) {
                        var html = '';
                        const role = '<?= $user['role'] ?>';
                        let adaFeedbackBaru = false;

                        function cocokkanRoleDenganLabel(role, label) {
                            const roleMap = {
                                BPP: 'BPP',
                                KAB: 'Kabupaten',
                                PROV: 'Provinsi'
                            };
                            return roleMap[role.toUpperCase()] === label;
                        }

                        function buatKomentar(label, isi, feedbackName, feedbackIsi) {
                            let komentarHtml = '';

                            if (role === 'PPL' || cocokkanRoleDenganLabel(role, label) ||
                                (role === 'KAB' && label === 'Provinsi')) {
                                komentarHtml += `<div class="mb-3">`;
                                komentarHtml += `<label class="form-label fw-bold">Catatan ${label}</label>`;
                                komentarHtml += `
                        <textarea class="form-control" rows="3" readonly>${isi || `${label} belum memberikan komentar.`}</textarea>
                    `;

                                if (role === 'PPL' && isi) {
                                    komentarHtml += `<label class="form-label mt-2">Feedback ke ${label}</label>`;
                                    komentarHtml += `
                            <textarea class="form-control" name="${feedbackName}" rows="3" ${feedbackIsi ? 'readonly' : ''}>
${feedbackIsi || ''}
                            </textarea>`;
                                    if (!feedbackIsi) adaFeedbackBaru = true;
                                }

                                if (role !== 'PPL' && cocokkanRoleDenganLabel(role, label)) {
                                    komentarHtml += `<label class="form-label mt-2 fw-bold">Feedback dari PPL</label>`;
                                    komentarHtml += `
                            <textarea class="form-control" name="${feedbackName}" rows="3" ${feedbackIsi ? 'readonly' : ''}>
${feedbackIsi || ''}
                            </textarea>`;
                                    if (!feedbackIsi) adaFeedbackBaru = true;
                                }

                                komentarHtml += `</div>`;
                            }

                            return komentarHtml;
                        }

                        html += buatKomentar('BPP', data.usulCatatanBpp, 'usulCatatanBppFeedback', data.usulCatatanBppFeedback);
                        html += buatKomentar('Kabupaten', data.usulCatatanKab, 'usulCatatanKabFeedback', data.usulCatatanKabFeedback);
                        html += buatKomentar('Provinsi', data.usulCatatanProv, 'usulCatatanProvFeedback', data.usulCatatanProvFeedback);

                        $('#containerKomentar').html(html);

                        if (adaFeedbackBaru) {
                            $('#submitFeedbackWrapper').removeClass('d-none');
                        } else {
                            $('#submitFeedbackWrapper').addClass('d-none');
                        }

                        $('#usulKodeKomentarLihat').val(usulKode);
                        $('#modalLihatKomentar').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Gagal mengambil data komentar:', error);
                    }
                });
            };
        });
    </script>
</body>

</html>