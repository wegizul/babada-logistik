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
 					<table class="table table-bordered" width="100%" style="font-size:120%;">
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
 								<td colspan="2">
 									<table>
 										<tr>
 											<td>
 												SHIP FROM :<br><br>
 												<b>PT LOGISTIK OLAH GEMILANG</b><br>
 												082283922582<br>
 												Jl. Lintas Timur Km. 14, Kulim<br>
 												Pekanbaru<br>
 											</td>
 											<td style="width: 40%;">
 												<?php echo '<img src="data:image/jpeg;base64,' . base64_encode($penjualan->pjl_barcode) . '" width="500px"/>'; ?>
 											</td>
 											<td>
 												SHIP TO :<br><br>
 												<b><?= $penjualan->pjl_customer ?></b><br>
 											</td>
 										</tr>
 										<tr>
 											<td colspan="3">
 												<b>Tanggal : </b><?= $penjualan->pjl_tanggal ?><br><br>
 											</td>
 										</tr>
 									</table>
 									<form method="POST" action="<?= base_url('Penjualan/edit_harga_resi/' . $penjualan->pjl_id) ?>">
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
 													<td>
 														<div class="input-group input-group-sm col-lg-12">
 															<div class="input-group-prepend">
 																<span class="input-group-text">Rp </span>
 															</div>
 															<input type="text" name="pjd_harga[]" id="pjd_harga" class="form-control form-control-sm" placeholder="<?= $d->pjd_harga ?>">
 															<input type="hidden" name="pjd_id[]" id="pjd_id" value="<?= $d->pjd_id ?>">
 														</div>
 													</td>
 												</tr>
 											<?php } ?>
 										</table>
 										<button type="submit" class="btn btn-dark mt-3" style="float: right;"><i class="fas fa-print"></i> Cetak</button>
 									</form>
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