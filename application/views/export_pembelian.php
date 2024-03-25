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
    header("Content-Disposition: attachment; filename=Laporan Pembelian bulan " . $bulan . ".xls");
    ?>

    <center>
        <h1>Laporan Pembelian Bulan <?= $bulan ?></h1>
    </center>

    <table border="1">
        <tr>
            <th>Tanggal</th>
            <th>No Faktur</th>
            <th>Supplier</th>
            <th>Total Item</th>
            <th>Total Harga</th>
            <th>user Input</th>
        </tr>
        <?php foreach ($data as $dt) { ?>
            <tr>
                <td><?= $dt->pbl_tanggal ?></td>
                <td><?= $dt->pbl_supplier ?></td>
                <td><?= $dt->pbl_no_faktur ?></td>
                <td><?= $dt->pbl_total_item . " Item" ?></td>
                <td>Rp. <?= number_format($dt->pbl_total_harga, 0) ?></td>
                <td><?= $dt->log_nama ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>