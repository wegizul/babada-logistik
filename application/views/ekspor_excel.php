<!DOCTYPE html>
<html>

<head>
    <title><?= $page ?></title>
</head>

<body>
    <style type="text/css">
        body {
            font-family: sans-serif;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #3c3c3c;
            padding: 3px 8px;

        }

        a {
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
    </style>

    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Booking " . $bulan . ".xls");
    ?>

    <center>
        <h1>Laporan Booking <?= $bulan ?></h1>
    </center>

    <table border="1">
        <tr>
            <th>Tanggal</th>
            <th>Kode Booking</th>
            <th>Jenis Produk</th>
            <th>Nama Pengirim</th>
            <th>Notelp Pengirim</th>
            <th>Alamat Pengirim</th>
            <th>Nama Penerima</th>
            <th>Notelp Penerima</th>
            <th>Alamat Penerima</th>
            <th>Kota Asal</th>
            <th>Kota Tujuan</th>
            <th>Tipe Komoditas</th>
            <th>Ongkos Kirim</th>
        </tr>
        <?php foreach ($data as $dt) { ?>
            <tr>
                <td><?= $dt->bk_tanggal ?></td>
                <td><?= $dt->bk_kode ?></td>
                <td><?= $dt->jp_nama ?></td>
                <td><?= $dt->bk_nama_pengirim ?></td>
                <td><?= $dt->bk_notelp_pengirim ?></td>
                <td><?= $dt->bk_alamat_pengirim ?></td>
                <td><?= $dt->bk_nama_penerima ?></td>
                <td><?= $dt->bk_notelp_penerima ?></td>
                <td><?= $dt->bk_alamat_penerima ?></td>
                <td><?= $dt->bk_kota_asal ?></td>
                <td><?= $dt->bk_kota_tujuan ?></td>
                <td><?= $dt->tk_nama ?></td>
                <td><?= $dt->bk_biaya ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>