 <!-- Theme style -->
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/dist/css/adminlte.min.css">
 <!-- Tempusdominus Bbootstrap 4 -->
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

 <!-- DataTables -->
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

 <style>
 	table {
 		border-collapse: collapse;
 		border: 1px solid #999;
 		font-family: Arial, sans-serif;
 		font-size: 16px;
 		width: 100%;
 		caption-side: top;
 	}

 	caption,
 	table th {
 		font-weight: bold;
 		padding: 30px;
 		color: #444;
 		background-color: #dddddd;
 		border-top: 1px black solid;
 		border-bottom: 1px black solid;
 	}

 	caption,
 	table td {
 		padding: 20px;
 		border-top: 1px black solid;
 		border-bottom: 1px black solid;
 		text-align: left;
 	}

 	caption {
 		font-weight: bold;
 		font-style: italic;
 	}

 	table .left {
 		text-align: left;
 		padding: 7px;
 	}
 </style>
 <div class="inner">
 	<div class="row">
 		<div class="col-lg-12">
 			<div class="card">
 				<div class="card-body table-responsive">
 					<table class="table table-borderless" width="100%" style="font-size:120%;">
 						<thead>
 							<tr>
 								<th>
 									<h1><b><?= $penjualan->pjl_faktur ?></b></h1>
 								</th>
 								<th>
 									<img src="<?= base_url('assets/files/logo.png') ?>" width="50px" style="float: right;">
 								</th>
 							</tr>
 						</thead>
 						<tbody>
 							<tr>
 								<td>
 									SHIP FROM :<br><br>
 									<b>PT LOGISTIK OLAH GEMILANG</b><br>
 									082283922582<br>
 									Jl. Lintas Timur Km. 14, Kulim<br>
 									Pekanbaru<br>
 								</td>
 								<td>
 									SHIP TO :<br><br>
 									<b><?= $penjualan->pjl_customer ?></b><br>
 								</td>
 							</tr>
 							<tr>
 								<td colspan="2">
 									<b>Tanggal : </b><?= $penjualan->pjl_tanggal ?><br><br>
 								</td>
 							</tr>
 							<tr>
 								<td colspan="2">
 									<table>
 										<tr>
 											<th style="width: 60%;">Item</th>
 											<th>Qty</th>
 											<th>Satuan</th>
 											<th>Harga</th>
 										</tr>
 										<?php foreach ($data as $d) { ?>
 											<tr>
 												<td><?= $d->mtl_nama ?></td>
 												<td><?= $d->pjd_qty ?></td>
 												<td><?= $d->smt_nama ?></td>
 												<td style="text-align: right;">Rp <?= number_format($d->pjd_harga, 0, ',', '.') ?></td>
 											</tr>
 										<?php } ?>
 										<tr>
 											<td colspan="3" style="text-align: right; font-weight:bold;">Total Harga</td>
 											<td colspan="3" style="text-align: right; font-weight:bold;">Rp <?= number_format($penjualan->pjl_jumlah_bayar, 0, ',', '.') ?></td>
 										</tr>
 									</table>
 								</td>
 							</tr>
 							<tr>
 								<td></td>
 								<td style="text-align:center; font-size:medium; padding-bottom:60px;">Pekanbaru, <?= date('d F Y') ?></td>
 							</tr>
 							<tr>
 								<td></td>
 								<td style="text-align:center; font-weight:bold;">CEO</td>
 							</tr>
 						</tbody>
 					</table>
 					<br><br>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>

 <script>
 	window.print()
 	setTimeout(function() {
 		window.close();
 	}, 100);
 </script>