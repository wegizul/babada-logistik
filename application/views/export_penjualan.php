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
    header("Content-Disposition: attachment; filename=Laporan Penjualan bulan " . $bulan . ".xls");
    ?>

    <center>
        <h1>Laporan Penjualan Bulan <?= $bulan ?></h1>
    </center>

    <table border="1">
        <tr>
            <th>Tanggal</th>
            <th>No Faktur</th>
            <th>Customer</th>
            <th>Total Item</th>
            <th>Jumlah Bayar</th>
            <th>Status Bayar</th>
            <th>user Input</th>
        </tr>
        <?php $pembayaran = '';
        foreach ($data as $dt) {
            switch ($dt->pjl_status_bayar) {
                case 0:
                    $pembayaran = "<span class='badge badge-warning'>Tertunda</span>";
                    break;
                case 1:
                    $pembayaran = "<span class='badge badge-danger'>Jatuh Tempo</span>";
                    break;
                case 2:
                    $pembayaran = "<span class='badge badge-success'>Lunas</span>";
                    break;
            } ?>
            <tr>
                <td><?= $dt->pjl_tanggal ?></td>
                <td><?= $dt->pjl_faktur ?></td>
                <td><?= $dt->pjl_customer ?></td>
                <td><?= $dt->pjl_total_item . " Item" ?></td>
                <td>Rp <?= number_format($dt->pjl_jumlah_bayar, 0, ',', '.') ?></td>
                <td><?= $pembayaran ?></td>
                <td><?= $dt->log_nama ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>