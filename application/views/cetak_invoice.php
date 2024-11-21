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
		font-size: 13px;
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
								<td colspan="2">
									<table>
										<tr>
											<td style="padding: 10px 0px 10px 20px;">
												SHIP FROM :<br><br>
												<b>PT LOGISTIK OLAH GEMILANG</b><br>
												082283922582<br>
												Jl. Lintas Timur Km. 14, Kulim, Pekanbaru<br>
											</td>
											<td style="width: 40%; padding-top: 10px;">
												<?php echo '<img src="data:image/jpeg;base64,' . base64_encode($penjualan->pjl_barcode) . '" width="300px"/>'; ?>
											</td>
											<td style="padding: 10px 0px 10px 20px;">
												SHIP TO :<br><br>
												<b><?= $penjualan->pjl_customer ?></b><br>
											</td>
										</tr>
									</table>
									<form method="POST" action="<?= base_url('Penjualan/edit_harga_resi/' . $penjualan->pjl_id) ?>">
										<table>
											<tr>
												<th style="width: 60%; text-align:right;">Item</th>
												<th>Qty</th>
												<th>Satuan</th>
												<th>Harga</th>
											</tr>
											<?php foreach ($data as $d) { ?>
												<tr>
													<?php if ($d->pjd_status == 6) {
														echo "<td style='text-align: right; padding:10px;' class='bg bg-danger'>" . $d->mtl_nama . " <i>(Item Tidak Tersedia)</i></td>";
													} else {
														echo "<td style='text-align: right; padding:10px;'>" . $d->mtl_nama . "</td>";
													} ?>
													<td style="padding:10px;"><?= $d->pjd_qty ?></td>
													<td style="padding:10px;"><?= $d->smt_nama ?></td>
													<td><?php if ($d->pjd_status == 6) { ?>
															<div class="input-group input-group-sm col-lg-12">
																<div class="input-group-prepend">
																	<span class="input-group-text">Rp </span>
																</div>
																<input type="text" name="pjd_harga[]" id="pjd_harga" class="form-control form-control-sm" value="0" disabled>
																<input type="hidden" name="pjd_id[]" id="pjd_id" value="<?= $d->pjd_id ?>">
															</div>
														<?php } else { ?>
															<div class="input-group input-group-sm col-lg-12">
																<div class="input-group-prepend">
																	<span class="input-group-text">Rp </span>
																</div>
																<input type="text" name="pjd_harga[]" id="pjd_harga" class="form-control form-control-sm" placeholder="<?= $d->pjd_harga ?>">
																<input type="hidden" name="pjd_id[]" id="pjd_id" value="<?= $d->pjd_id ?>">
															</div>
														<?php } ?>
													</td>
												</tr>
											<?php } ?>
										</table>
										<button type="submit" class="btn btn-dark mt-3 btn-sm" style="float: right;"><i class="fas fa-print"></i> Cetak</button>
										<a href="javascript:window.close()" class="btn btn-danger btn-sm mt-3 mr-2" style="float: right;"><i class="fas fa-times-circle"></i> Batal</a>
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>