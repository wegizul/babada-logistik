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
    header("Content-Disposition: attachment; filename=Laporan Rekap Material bulan " . $bulan . ".xls");
    ?>

    <center>
        <h1>Laporan Rekap Material Bulan <?= $bulan ?></h1>
    </center>

    <table border="1">
        <tr>
            <th>Jenis</th>
            <th>Nama Material</th>
            <th>Total Pembelian</th>
            <th>Total Penjualan</th>
            <th>Stok</th>
        </tr>
        <?php foreach ($data as $dt) { ?>
            <tr>
                <td><?= $dt['jp_nama'] ?></td>
                <td><?= $dt['mtl_nama'] ?></td>
                <td><?= $dt['topel'] ?></td>
                <td><?= $dt['topen'] ?></td>
                <td><?= $dt['stok'] ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>