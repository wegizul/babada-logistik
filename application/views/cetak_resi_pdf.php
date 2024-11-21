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
 		font-size: 14px;
 		width: 100%;
 	}

 	table th {
 		font-weight: bold;
 		color: #444;
 		background-color: #dddddd;
 		border-top: 1px black solid;
 		border-bottom: 1px black solid;
 	}

 	.table td {
 		padding: .5rem;
 		text-align: left;
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
 									<h3 style="margin-bottom: -5px;"><b><?= $penjualan->pjl_faktur ?></b></h3>
 									<small style="font-size: 12px;"><b>Tanggal : </b><?= $penjualan->pjl_tanggal ?></small>
 								</th>
 								<th>
 									<img src="<?= base_url('assets/files/logo.png') ?>" width="50px" style="float: right;">
 								</th>
 							</tr>
 						</thead>
 						<tbody>
 							<tr>
 								<td style="font-size: medium;">
 									SHIP FROM :<br><br>
 									<b>PT LOGISTIK OLAH GEMILANG</b><br>
 									082283922582<br>
 									Jl. Lintas Timur Km. 14, Kulim, Pekanbaru<br>
 								</td>
 								<td style="font-size: medium;">
 									SHIP TO :<br><br>
 									<b><?= $penjualan->pjl_customer ?></b><br>
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
 												<?php if ($d->pjd_status == 6) {
														echo "<td class='text-danger'>" . $d->mtl_nama . " <i>(Item Tidak Tersedia)</i></td>";
													} else {
														echo "<td>" . $d->mtl_nama . "</td>";
													} ?>
 												<td><?= $d->pjd_qty ?></td>
 												<td><?= $d->smt_nama ?></td>
 												<?php if ($d->pjd_status == 6) { ?>
 													<td style="text-align: right; color:red;">Rp 0</td>
 												<?php } else { ?>
 													<td style="text-align: right;">Rp <?= number_format($d->pjd_harga, 0, ',', '.') ?></td>
 												<?php } ?>
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