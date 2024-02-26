<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-dark">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-search fa-sm"></i> Lacak Paket</h3>
				</div>
				<form role="form col-lg" id="form_cari1" action="<?= base_url('LacakPaket/cari') ?>" method="post" enctype="multipart/form-data">
					<div class="card-body form">
						<label>Masukan Nomor Resi</label>
						<?= $this->session->flashdata('message'); ?>
						<div class="row">
							<div class="col-lg-8">
								<input type="text" name="kode" id="kode" class="form-control" autofocus required>
							</div>
							<div class="col-lg-1">
								<button type="submit" id="cari" class="btn btn-dark"><i class="fas fa-search"></i> Cari</button>
							</div>
							<div class="col-lg-2">
								<a href="<?= base_url('LacakPaket/tampil') ?>" class="btn btn-dark"><i class="fas fa-history"></i> Reset</a>
							</div>
							<hr size="2" width="100%">
							<?php if ($bd_kode) { ?>
								<section class="content">
									<div class="container-fluid">
										<div class="row">
											<div class="col-lg-12">
												<h2><b>Tracking No Resi #<?= $kode ?></b></h2>
												<div class="timeline">
													<?php foreach ($data as $dt) { ?>
														<div>
															<?php if ($dt->tr_jenis == 4) { ?>
																<i class="fas fa-box-open bg-dark"></i>
															<?php } else if ($dt->tr_jenis == 0) { ?>
																<i class="fas fa-cart-plus bg-dark"></i>
															<?php } else { ?>
																<i class="fas fa-truck-fast bg-yellow"></i>
															<?php } ?>
															<div class="timeline-item col-lg-12">
																<span class="time"><i class="fas fa-clock"></i> <?= $dt->tr_waktu_scan ?></span>
																<h3 class="timeline-header"><a href="#"><?= $dt->sp_nama ?></a></h3>
																<div class="timeline-body">
																	<?php switch ($dt->tr_jenis) {
																		case 0:
																			$ket = "Booking Created";
																			break;
																		case 1:
																			$ket = "Paket telah tiba di lokasi " . $dt->sp_nama . " " . $dt->log_agen;
																			break;
																		case 2:
																			$ket = "Paket akan dikirimkan ke " . $dt->tr_tujuan;
																			break;
																		case 3:
																			$ket = "Paket akan dikirimkan ke " . $dt->tr_tujuan;
																			break;
																		case 4:
																			$ket = "Paket telah diterima oleh yang bersangkutan";
																			break;
																	} ?>
																	<?= $ket ?>
																</div>
															</div>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</section>
								<!-- <table class="table table-bordered" style="width: 70%; font-size:small;">
									<tr>
										<th colspan="2" style="background-color: #ffff00;"><?= $bd_kode ?><span style="float: right;">Status : <?= $sp_nama ?></span></th>
									</tr>
									<tr style="background-color: #ececfe;">
										<td>
											<b>Nama Pengirim</b><br>
											<h6><?= $bk_nama_pengirim ?></h6>
											<b>No Handphone</b><br>
											<h6><?= $bk_notelp_pengirim ?></h6>
										</td>
										<td>
											<b>Nama Penerima</b><br>
											<h6><?= $bk_nama_penerima ?></h6>
											<b>No Handphone</b><br>
											<h6><?= $bk_notelp_penerima ?></h6>
										</td>
									</tr>
									<tr style="background-color: #ececfe;">
										<td colspan="2">
											<u><b>Detail Paket</b></u><br>
											<span>Berat : <?= $bd_berat_barang ?> Kg</span><br>
											<span>Dimensi : <?= $bd_panjang . ' x ' . $bd_lebar . ' x ' . $bd_tinggi ?> cm</span><br>
										</td>
									</tr>
								</table> -->
							<?php } else {
								echo "<small><i>Tidak ada data / Data tidak ditemukan</i></small>";
							} ?>
						</div>
					</div>
					<div class="card-footer">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">

</div>

<!-- date-range-picker -->
<script src="<?= base_url("assets"); ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Select 2 -->
<script src="<?= base_url("assets"); ?>/plugins/select2/js/select2.full.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Sweet alert -->
<script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<!-- jquery mask -->
<script src="<?= base_url(); ?>assets/jquery-mask/dist/jquery.mask.min.js"></script>

<!-- Custom Java Script -->
<script>
	function reset_form() {
		$("#bk_id").val(0);
		$("#frm_booking")[0].reset();
	}

	$(document).ready(function() {});
</script>