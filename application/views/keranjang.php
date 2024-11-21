<div class="container">
	<div class="row">
		<?= $this->session->flashdata('error'); ?>

		<div class="col-lg-12">
			<div class="card card-dark">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-cart-plus fa-sm"></i> <?= $page ?></h3>
				</div>
				<form role="form col-lg" name="Checkout" id="frm_checkout" method="post" enctype="multipart/form-data">
					<div class="card-body form">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<table class="table">
										<tr>
											<th>
												<label>Gambar</label>
											</th>
											<th>
												<label>Nama Barang</label>
											</th>
											<th>
												<label>Quantity</label>
											</th>
											<th>
												<label>Total Harga</label>
											</th>
											<th>
												<label>Hapus</label>
											</th>
										</tr>
										<?php $total_harga = 0;
										$total_bayar = 0;
										foreach ($data as $d) {
											$total_harga = $d->pjd_jumlah * $d->mtl_harga_jual;
											$total_bayar += $total_harga; ?>
											<tr>
												<td>
													<img src="<?= base_url('assets/files/material/' . $d->mtl_foto) ?>" width="100px">
												</td>
												<td><?= $d->mtl_nama ?></td>
												<td>
													<div class="input-group input-group-sm mb-3" style="width:30%;">
														<input type="number" min="0" class="form-control" onkeyup="ubah_qty(this.value, <?= $d->pjd_id ?>)" value="<?= $d->pjd_jumlah ?>" required>
													</div>
												</td>
												<td>Rp. <?= number_format($total_harga, 0) ?></td>
												<td>
													<a href="javascript:hapus(<?= $d->pjd_id ?>, <?= $d->mtl_id ?>, <?= $d->pjd_jumlah ?>)"><i class="fas fa-trash-alt text-danger"></i> </a>
												</td>
											</tr>
										<?php } ?>
										<tr>
											<td colspan="3" class="text-right">
												<h3><b>Total Bayar :</b></h3>
											</td>
											<td>
												<h3><b>Rp. <?= number_format($total_bayar, 0) ?></b></h3>
											</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="3" class="text-right">
												<h6>Metode Pembayaran :</h6>
											</td>
											<td>
												<select class="form-control form-control-sm" name="pjl_jenis_bayar" id="pjl_jenis_bayar" required>
													<option value="1">Transfer</option>
													<option value="2">Cash</option>
												</select>
											</td>
											<td></td>
										</tr>
									</table>
									<input type="hidden" name="pjl_user" id="pjl_user" value="<?= $this->session->userdata('id_user'); ?>">
									<input type="hidden" name="pjl_jumlah_bayar" id="pjl_jumlah_bayar" value="<?= $total_bayar ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="col-lg-12" style="float:right;">
							<button type="submit" id="bk_simpan" class="btn btn-dark btn-sm" style="float: right;"><i class="fas fa-check-circle"></i> Checkout</button>
						</div>
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
	var save_method; //for save method string
	var table;

	$("#frm_checkout").submit(function(e) {
		e.preventDefault();
		$("#bk_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "<?= base_url('Penjualan/checkout') ?>",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					Swal.fire(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {
							window.location.href = "<?= base_url('Penjualan/riwayat') ?>";
						} else {}
					})
				} else {
					toastr.error(res.desc);
				}
				$("#bk_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#bk_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function ubah_qty(nilai, id) {
		$.ajax({
			type: "POST",
			url: "<?= base_url('Penjualan/ubah_qty/') ?>" + id + "/" + nilai,
			dataType: "json",
			success: function(data) {
				window.location.reload();
			}
		});
	}

	function hapus(id, mtl, jml) {
		$("#id2").val(id);
		$("#mtl").val(mtl);
		$("#jml").val(jml);
		$("#jdlKonfirm2").html("Konfirmasi hapus item");
		$("#isiKonfirm2").html("Yakin ingin menghapus item ini ?");
		$("#frmKonfirm2").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#yaKonfirm2").click(function() {
		var id = $("#id2").val();
		var mtl = $("#mtl").val();
		var jml = $("#jml").val();
		$("#isiKonfirm2").html("Sedang menghapus item...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "<?= base_url('Penjualan/hapus/') ?>" + id + "/" + mtl + "/" + jml,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					$("#frmKonfirm2").modal("hide");
					Swal.fire(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {
							window.location.href = "<?= base_url('Penjualan/cart') ?>";
						} else {}
					})
				} else {
					toastr.error(res.desc + "[" + res.err + "]");
				}
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	});

	$(document).ready(function() {});
</script>