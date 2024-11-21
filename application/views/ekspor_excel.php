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
        <h1>Laporan Pembelian <?= $bulan ?></h1>
    </center>

    <table border="1">
        <tr>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Nomor Faktur</th>
            <th>Item</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Total Harga</th>
        </tr>
        <?php foreach ($data as $dt) { ?>
            <tr>
                <td><?= $dt->pbl_tanggal ?></td>
                <td><?= $dt->pbl_supplier ?></td>
                <td><?= $dt->pbl_no_faktur ?></td>
                <td><?= $dt->mtl_nama ?></td>
                <td><?= $dt->pbd_qty ?></td>
                <td><?= $dt->smt_nama ?></td>
                <td><?= $dt->pbd_harga ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>