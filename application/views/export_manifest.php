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
    header("Content-Disposition: attachment; filename=Laporan Manifest bulan " . $bulan . ".xls");
    ?>

    <center>
        <h1>Laporan Manifest Bulan <?= $bulan ?></h1>
    </center>

    <table border="1">
        <tr>
            <th>Kode Manifest</th>
            <th>Tgl Pickup</th>
            <th>Tujuan</th>
            <th>Nama Supir</th>
            <th>Total Paket</th>
            <th>User Input</th>
        </tr>
        <?php foreach ($data as $dt) { ?>
            <tr>
                <td><?= $dt->mf_kode ?></td>
                <td><?= $dt->mf_tgl_pickup ?></td>
                <td><?= $dt->mf_tujuan ?></td>
                <td><?= $dt->mf_supir ?></td>
                <td><?= $dt->mf_total_paket . " Item" ?></td>
                <td><?= $dt->log_nama ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>