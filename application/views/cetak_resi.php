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
 		padding: 10px;
 		color: #fff;
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

 	<div class="row" id="isidata">
 		<div class="col-lg-12">
 			<div class="card">
 				<div class="card-body table-responsive">
 					<?php for ($i = 0; $i < $jumlah; $i++) { ?>
 						<table class="table table-bordered" width="100%" style="font-size:120%;">
 							<thead>
 								<tr>
 									<th>
 										<h1><b><?= $data[$i]->sp_kode ?></b></h1>
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
 													SHIP FROM :<br>
 													<b><?= $data[$i]->bk_nama_pengirim ?></b><br>
 													<?= $data[$i]->bk_notelp_pengirim ?><br>
 													<?= $data[$i]->bk_alamat_pengirim ?><br>
 													<?= $data[$i]->bk_kota_asal ?><br>
 												</td>
 												<td>
 													SHIP TO :<br>
 													<b><?= $data[$i]->bk_nama_penerima ?></b><br>
 													<?= $data[$i]->bk_notelp_penerima ?><br>
 													<?= $data[$i]->bk_alamat_penerima ?><br>
 													<?= $data[$i]->bk_kota_tujuan ?><br>
 													<span class="badge badge-success"><?= $data[$i]->ta_nama ?></span>
 												</td>
 											</tr>
 											<tr>
 												<td>
 													<b>Tanggal : </b><?= $data[$i]->bk_tanggal ?><br><br>
 													<b>Jenis Produk Pengiriman : </b><?= $data[$i]->jp_nama ?><br><br>
 													<b>Tipe Komoditas : </b><?= $data[$i]->tk_nama ?><br><br>
 												</td>
 												<td>
 													<u><b>Detail Paket</b></u><br>
 													<span>Berat : <?= $data[$i]->bd_berat_barang ?> Kg</span><br>
 													<span>Dimensi : <?= $data[$i]->bd_panjang . ' x ' . $data[$i]->bd_lebar . ' x ' . $data[$i]->bd_tinggi ?> cm</span><br>
 												</td>
 											</tr>
 											<tr>
 												<td colspan="2">
 													<img src="<?= base_url("assets/files/barcode/{$data[$i]->bd_kode}.png") ?>" width="100%">
 												</td>
 											</tr>
 										</table>
 									</td>
 								</tr>
 							</tbody>
 						</table>
 					<?php } ?>
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