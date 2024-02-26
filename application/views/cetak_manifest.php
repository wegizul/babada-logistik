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
 		font-size: 16px;
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
 </style>
 <div class="inner">

 	<div class="row" id="isidata">
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
 								<td colspan="2" style="padding-top: 50px;">
 									<table>
 										<tr>
 											<td style="width: 20%;">Nama POS</td>
 											<td>: <?= $manifest->mf_pos ?></td>
 											<td style="width: 20%;">No. Seri Kendaraan</td>
 											<td>: <?= $manifest->mf_nopol ?></td>
 										</tr>
 										<tr>
 											<td style="width: 20%;">Kota Asal</td>
 											<td>: <?= $manifest->mf_kota_asal ?></td>
 											<td style="width: 20%;">Total Paket</td>
 											<td>: <?= $manifest->mf_total_paket ?></td>
 										</tr>
 										<tr>
 											<td style="width: 20%;">Tanggal Pickup</td>
 											<td>: <?= $manifest->mf_tgl_pickup ?></td>
 											<td style="width: 20%;">Total Berat</td>
 											<td>: <?= $manifest->mf_total_berat ?> Kg</td>
 										</tr>
 										<tr>
 											<td style="width: 20%;">Nama Kurir</td>
 											<td>: <?= $manifest->mf_kurir ?></td>
 											<td style="width: 20%;"></td>
 											<td></td>
 										</tr>
 										<tr>
 											<td style="width: 20%;">No. Telp Kurir</td>
 											<td>: <?= $manifest->mf_telp_kurir ?></td>
 											<td style="width: 20%;"></td>
 											<td></td>
 										</tr>
 									</table>
 								</td>
 							</tr>
 							<tr>
 								<td colspan="2" style="padding-top: 50px;">
 									<table id="paket">
 										<tr>
 											<th>No.</th>
 											<th>Nomor Resi</th>
 											<th>Tanggal</th>
 											<th>Produk</th>
 											<th>Berat</th>
 											<th>Destination</th>
 										</tr>
 										<?php $i = 1;
											foreach ($tracking as $tr) { ?>
 											<tr>
 												<td><?= $i++ ?></td>
 												<td><?= $tr->tr_bd_kode ?></td>
 												<td><?= $tr->tr_waktu_scan ?></td>
 												<td><?= $tr->jp_nama ?></td>
 												<td><?= $tr->bd_berat_barang ?> Kg</td>
 												<td><?= $tr->tr_tujuan ?></td>
 											</tr>
 										<?php } ?>
 									</table>
 								</td>
 							</tr>
 						</tbody>
 					</table>
 					<br><br>
 					<table>
 						<tr>
 							<td style="text-align: center;">Pos/Pengirim</td>
 							<td style="text-align: center;">Kurir</td>
 							<td style="text-align: center;">Operation Supervisor</td>
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