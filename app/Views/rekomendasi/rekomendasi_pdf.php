<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Report Pelaporan Kondisi Alsintan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: white;
            font-size: 12px;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            background-color: white;
            border: 2px solid #000;
            padding: 0;
        }

        .form-content {
            border: 2px solid #000;
            margin: 15px;
            padding: 20px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
            text-decoration: underline;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-row {
            margin-bottom: 8px;
            font-size: 12px;
            display: flex;
        }

        .info-label {
            width: 80px;
            font-weight: bold;
        }

        .status-text {
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 9px;
            line-height: 1.2;
        }

        .table-row {
            height: 30px;
        }

        .date-location {
            text-align: right;
            margin: 30px 0 40px 0;
            font-size: 12px;
        }

        .signature-section {
            display: table;
            width: 100%;
            margin-top: 40px;
        }

        .signature-left {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding-right: 20px;
        }

        .signature-right {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding-left: 20px;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .signature-role {
            margin-bottom: 80px;
            font-size: 11px;
        }

        .signature-name {
            font-weight: bold;
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 150px;
            margin-bottom: 5px;
            font-size: 12px;
            padding-bottom: 2px;
        }

        .signature-nip {
            font-size: 11px;
        }

        .signature-image {
            margin: 10px 0;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media print {
            body {
                margin: 0;
                padding: 10px;
            }

            .container {
                border: 2px solid #000;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-content">
            <div class="title">
                <!-- Beda role beda judul antara PROV, KAB, PPL -->
                <?php if ($user['role'] == 'KAB'): ?>
                    FORM REPORT PELAPORAN KONDISI ALSINTAN KABUPATEN/KOTA
                <?php elseif ($user['role'] == 'PPL'): ?>
                    FORM REPORT PELAPORAN KONDISI ALSINTAN DI POKTAN/GAPOKTAN
                <?php else: ?>
                    FORM REPORT PELAPORAN KONDISI ALSINTAN KABUPATEN/KOTA
                <?php endif; ?>
            </div>

            <div class="info-section">
                <?php if ($user['role'] == 'KAB' || $user['role'] == 'PROV'): ?>
                    <div class="info-row">
                        <span class="info-label">Dinas</span>
                        <span>: <?= $namaInstansi ?></span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Kabupaten</span>
                        <span>: <?= $namaKota ?></span>
                    </div>
                <?php elseif ($user['role'] == 'PPL'): ?>
                    <div class="info-row">
                        <span class="info-label">Kabupaten</span>
                        <span>: <?= $namaKota ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kecamatan</span>
                        <span>: <?= $namaKecamatan ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Desa</span>
                        <span>: <?= $namaDesa ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nama Penyuluh</span>
                        <span>: <?= $namaPenyuluh ?></span>
                    </div>
                <?php endif; ?>

                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span>: <span class="status-text">Disetujui <?= $rekomendasi ? '('.$rekomendasi.')' : '' ?></span></span>
                </div>
            </div>

            <table>
                <?php if($rekomendasiData != null): ?>
                    <?php if ($user['role'] == 'KAB' || $user['role'] == 'PROV'): ?>
                        <thead>
                            <tr>
                                <th>ID<br>ALSIN</th>
                                <th>TYPE</th>
                                <th>NOMER<br>MESIN</th>
                                <th>NOMER<br>RANGKA</th>
                                <th>STATUS<br>ALSIN</th>
                                <th>KOMODITI<br>YANG<br>DISARANKAN</th>
                                <th>CATATAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekomendasiData as $item): ?>
                                <tr class="table-row">
                                    <td><?= $item['usulKode'] ?></td>
                                    <td><?= $item['tipeNama'] ?></td>
                                    <td><?= $item['usulNoMesin'] ?></td>
                                    <td><?= $item['usulNoRangka'] ?></td>
                                    <td><?= $item['usulStatus'] ?></td>
                                    <td><?= $item['usulKomoditi'] ?></td>
                                    <td><?= $item['catatan'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    <?php elseif ($user['role'] == 'PPL'): ?>
                        <thead>
                            <tr>
                                <th>ID<br>ALSIN</th>
                                <th>NAMA<br>POKTAN/GAPOKTAN</th>
                                <th>TYPE</th>
                                <th>NOMER<br>MESIN</th>
                                <th>NOMER<br>RANGKA</th>
                                <th>STATUS<br>ALSIN</th>
                                <th>KOMODITI<br>YANG<br>DISARANKAN</th>
                                <th>CATATAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rekomendasiData as $item): ?>
                                <tr class="table-row">
                                    <td><?= $item['usulKode'] ?></td>
                                    <td><?= $item['namaPoktan'] ?></td>
                                    <td><?= $item['tipeNama'] ?></td>
                                    <td><?= $item['usulNoMesin'] ?></td>
                                    <td><?= $item['usulNoRangka'] ?></td>
                                    <td><?= $item['usulStatus'] ?></td>
                                    <td><?= $item['usulKomoditi'] ?></td>
                                    <td><?= $item['catatan'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Jika tidak ada rekomendasi, tampilkan pesan -->
                    <thead>
                        <tr>
                            <th colspan="8" style="text-align: center; font-size: 12px;">Tidak ada rekomendasi yang tersedia.</th>
                        </tr>
                    </thead>
                <?php endif; ?>
            </table>

            <div class="date-location">
                <?= $tempat ?>
            </div>

            <div class="signature-section">
                <div class="signature-left">
                    <div class="signature-title">MENGUSULKAN</div>
                    <?php if ($user['role'] == 'PROV'): ?>
                    <div class="signature-role">Kepala Bidang PSP Provinsi</div>
                    <?php elseif ($user['role'] == 'KAB'): ?>
                    <div class="signature-role">Kepala Bidang PSP Kabupaten/Kota</div>
                    <?php elseif ($user['role'] == 'PPL'): ?>
                    <div class="signature-role">Kepala Balai BPP</div>
                    <?php endif; ?>
                    <div class="signature-image">
                        <!-- <img src="<?= $ttdKabid ?>" alt="" style="max-width: 80px; max-height: 60px; border: 1px solid #ccc;">
                     -->
                    </div>
                    <div class="signature-name"><?= $namaKabid ?></div>
                    <div class="signature-nip">NIP. <?= $nipKabid ?></div>
                </div>

                <div class="signature-right">
                    <div class="signature-title">MENYETUJUI</div>
                    <?php if ($user['role'] == 'PROV'): ?>
                        <div class="signature-role">Kepala Dinas Provinsi</div>
                    <?php elseif ($user['role'] == 'KAB'): ?>
                        <div class="signature-role">Kepala Dinas</div>
                    <?php elseif ($user['role'] == 'PPL'): ?>
                        <div class="signature-role">Kepala Bidang PSP<br><?= $namaPendekInstansi ?></div>
                    <?php endif; ?>
                    <div class="signature-image">
                        <!-- <img src="<?= $ttdKepala ?>" alt="" style="max-width: 80px; max-height: 60px; border: 1px solid #ccc;">
                     -->
                    </div>
                    <div class="signature-name"><?= $namaKepala ?></div>
                    <div class="signature-nip">NIP. <?= $nipKepala ?></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>