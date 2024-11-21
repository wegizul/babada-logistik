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
 		border: none;
 		font-family: Arial, sans-serif;
 		font-size: 12px;
 		width: 100%;
 		caption-side: top;
 	}

 	caption,
 	table th {
 		font-weight: bold;
 		padding: 10px;
 		color: #999;
 	}

 	caption,
 	table td {
 		padding: 5px;
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

 	table #paket th {
 		border: 1px #999 solid;
 	}

 	table #paket td {
 		border: 1px #999 solid;
 	}
 	
 	@media print {
    .pagebreak { page-break-after: always; } /* page-break-after works, as well */
    }
 </style>
 <div class="inner">
 	<div class="row">
 		<div class="col-lg-12">
 			<div class="card">
 				<div class="card-body table-responsive">
 					<table width="100%" style="font-size:120%;">
 						<thead style="border-bottom: 1px #aaa solid;">
 							<tr>
 								<th>
 									<h2><b>Pickup Manifest - <?= $manifest->mf_kode ?></b></h1>
 								</th>
 								<th>
 									<img src="<?= base_url('assets/files/logo.png') ?>" width="70px" style="float: right;">
 								</th>
 							</tr>
 						</thead>
 						<tbody>
 							<tr>
 								<td colspan="2" style="padding-top: 20px;">
 								</td>
 							</tr>
 							<tr>
 								<td colspan="4" style="padding-top: 20px;">
 									<?php $i = 1;
										foreach ($tracking as $tr) { ?>
										<table>
 										<tr>
 											<td style="width: 20%;">Pengirim</td>
 											<td>: PT LOGISTIK OLAH GEMILANG</td>
 											<td style="width: 20%;">Nama Supir</td>
 											<td>: <?= $manifest->mf_supir ?></td>
 										</tr>
 										<tr>
 											<td style="width: 20%;">Total Item</td>
 											<td>: <?= $manifest->mf_total_paket ?></td>
 											<td style="width: 20%;">No. Telp Supir</td>
 											<td>: <?= $manifest->mf_telp_supir ?></td>
 										</tr>
 										<tr>
 											<td style="width: 20%;">Tanggal Pickup</td>
 											<td>: <?= $manifest->mf_tgl_pickup ?></td>
 											<td style="width: 20%;">No. Seri Kendaraan</td>
 											<td>: <?= $manifest->mf_nopol ?></td>
 										</tr>
 									</table>
 									<table id="paket">
     										<tr>
     											<th>No.</th>
     											<th>Tanggal Kirim</th>
     											<th>Nomor Invoice</th>
     											<th>Jumlah Item</th>
     											<th>Tujuan</th>
     										</tr>
 											<tr>
 												<td><?= $i++ ?></td>
 												<td><?= $tr->tr_waktu_scan ?></td>
 												<td><b><?= $tr->tr_pjl_faktur ?></b>
 													<ol start="1">
 														<?php foreach ($detail[$tr->tr_pjl_faktur] as $d) { ?>
 															<?php if ($d->pjd_status == 6) {
																	echo "<li class='text-danger'>" . $d->mtl_nama . ' <b>(' . $d->pjd_qty . $d->smt_nama . ')</b>' . " <i>(Item Tidak Tersedia)</i></li>";
																} else {
																	echo "<li>" .  $d->mtl_nama . ' <b>(' . $d->pjd_qty . $d->smt_nama . ')</b>' . "</li>";
																} ?>
 														<?php } ?>
 													</ol>
 												</td>
 												<td><?= $tr->pjl_total_item ?></td>
 												<td><?= $tr->tr_tujuan ?></td>
 											</tr>
 									</table>
 									<table>
 											<tr>
                         					    <td style="text-align: center;">Pengirim</td>
                         						<td style="text-align: center;">Supir</td>
                         						<td style="text-align: center;">Penerima</td>
                         					</tr>
                         					<tr>
                         						<td style="padding:40px"></td>
                         					</tr>
                         					<tr>
                         						<td style="text-align: center;">(.......................................)</td>
                         						<td style="text-align: center;">(.......................................)</td>
                         						<td style="text-align: center;">(.......................................)</td>
                         					</tr>
                         			</table>
										<div class="pagebreak"></div>
 									<?php } ?>
 								</td>
 							</tr>
 						</tbody>
 					</table>
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