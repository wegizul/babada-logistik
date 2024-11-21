 <!-- Theme style -->
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/dist/css/adminlte.min.css">
 <!-- Tempusdominus Bbootstrap 4 -->
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

 <!-- DataTables -->
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
 <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

 <link rel="icon" href="<?= base_url("assets/"); ?>files/logo.png" type="image/jpg">
 <!-- Font Awesome Icons -->
 <script src="https://kit.fontawesome.com/c1fd40eeb3.js" crossorigin="anonymous"></script>

 <style>
 	table {
 		font-family: Arial, sans-serif;
 		font-size: 10px;
 		width: 100%;
 		caption-side: top;
 	}

 	table th {
 		font-weight: bold;
 		padding: 30px;
 		color: #444;
 		background-color: #dddddd;
 	}

 	.table td {
 		padding: .1rem;
 		text-align: left;
 	}

 	img {
 		display: block;
 		margin-left: auto;
 		margin-right: auto;
 	}
 </style>
 <div class="inner">
 	<div class="row">
 		<div class="col-lg-12">
 			<div class="card">
 				<div class="card-body table-responsive">
 					<table class="table table-bordered" width="100%" style="font-size:120%;">
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
 								<td width="50%">
 									<table class="table table-bordered">
 										<tr>
 											<th style="width: 60%;">Item</th>
 											<th>Qty</th>
 											<th>Satuan</th>
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
 											</tr>
 										<?php } ?>
 									</table>
 								</td>
 								<td>
 									<table class="table table-borderless">
 										<tr>
 											<td style="width: 40%; padding-top:15px;">
 												<?php echo '<img src="data:image/jpeg;base64,' . base64_encode($penjualan->pjl_barcode) . '" width="400px"/>'; ?>
 											</td>
 										</tr>
 										<tr>
 											<td style="padding:15px 5px 15px 15px;">
 												SHIP FROM :<br>
 												<b>PT LOGISTIK OLAH GEMILANG</b><br>
 												082283922582<br>
 												Jl. Lintas Timur Km. 14, Kulim, Pekanbaru
 											</td>
 										</tr>
 										<tr>
 											<td style="padding:15px 5px 15px 15px;">
 												SHIP TO :<br>
 												<b><?= $penjualan->pjl_customer ?></b><br>
 											</td>
 										</tr>
 									</table>
 								</td>
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