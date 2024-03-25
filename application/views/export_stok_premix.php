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
    header("Content-Disposition: attachment; filename=Laporan Penyesuaian Stok Premix bulan " . $bulan . ".xls");
    ?>

    <center>
        <h1>Laporan Penyesuaian Stok Premix Bulan <?= $bulan ?></h1>
    </center>

    <table border="1">
        <tr>
            <th>Tanggal</th>
            <th>Premix</th>
            <th>Tipe</th>
            <th>Qty</th>
            <th>user Input</th>
        </tr>
        <?php foreach ($data as $dt) { ?>
            <tr>
                <td><?= $dt->pxs_date_created ?></td>
                <td><?= $dt->pmx_nama ?></td>
                <td><?= $dt->pxs_tipe == 1 ? "Penambahan" : "Pengurangan" ?></td>
                <td><?= $dt->pxs_qty . " Karung" ?></td>
                <td><?= $dt->log_nama ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>