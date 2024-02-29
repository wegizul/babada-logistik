<div class="container">
	<div class="row">
		<?= $this->session->flashdata('error'); ?>
		<div class="card card-dark">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-cart-plus fa-sm"></i> Pembelian / Barang Masuk</h3>
			</div>
			<form role="form col-lg" name="Booking" id="frm_booking" method="post" enctype="multipart/form-data">
				<div class="card-body form">
					<div class="row">
						<input type="hidden" id="bk_id" name="bk_id" value="">

						<div class="col-lg-12">
							<div class="form-group">
								<label>Produk Pengiriman</label> <span class="text-danger">*</span>
								<select class="form-control form-control-sm" name="bk_jenis_produk" id="bk_jenis_produk" style="width:30%;line-height:100px;" required>
									<option value="">Pilih Produk</option>
									<?php foreach ($jenisproduk as $jp) { ?>
										<option value="<?= $jp->jp_id ?>"><?= strtoupper($jp->jp_nama) ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<hr size="2" width="100%">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Pengirim</label> <span class="text-danger">*</span>
								<input type="text" class="form-control form-control-sm" name="bk_nama_pengirim" id="bk_nama_pengirim" autocomplete="off" placeholder="Masukan nama pengirim" required>
							</div>
							<label>No. Handphone Pengirim</label> <span class="text-danger">*</span>
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="number" min="0" class="form-control form-control-sm" name="bk_notelp_pengirim" id="bk_notelp_pengirim" autocomplete="off" placeholder="cth. 0812345678" required>
							</div>
							<div class="form-group">
								<label>Alamat Pengirim</label> <span class="text-danger">*</span>
								<textarea rows="3" class="form-control form-control-sm" name="bk_alamat_pengirim" id="bk_alamat_pengirim" autocomplete="off" placeholder="Masukan alamat pengirim" required></textarea>
							</div>
							<div class="form-group">
								<label>Kecamatan, Kota Asal</label> <span class="text-danger">*</span>
								<select class="form-control form-control-sm select2" name="bk_kota_asal" id="bk_kota_asal" style="width:100%;line-height:100px;" required>
									<option value="">Pilih Kota Asal</option>
									<?php foreach ($kota as $kt) { ?>
										<option value="<?= $kt->kec_nama . ', ' . $kt->kot_nama . ', ' . $kt->prov_nama ?>"><?= strtoupper($kt->kec_nama . ', ' . $kt->kot_nama . ', ' . $kt->prov_nama) ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Penerima</label> <span class="text-danger">*</span>
								<input type="text" class="form-control form-control-sm" name="bk_nama_penerima" id="bk_nama_penerima" autocomplete="off" placeholder="Masukan nama penerima" required>
							</div>
							<label>No. Handphone Penerima</label> <span class="text-danger">*</span>
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="number" min="0" class="form-control form-control-sm" name="bk_notelp_penerima" id="bk_notelp_penerima" autocomplete="off" placeholder="cth. 0812345678" required>
							</div>
							<div class="form-group">
								<label>Alamat Penerima</label> <span class="text-danger">*</span>
								<textarea rows="3" class="form-control form-control-sm" name="bk_alamat_penerima" id="bk_alamat_penerima" autocomplete="off" placeholder="Masukan alamat penerima" required></textarea>
							</div>
							<div class="form-group">
								<label>Kecamatan, Kota Tujuan</label> <span class="text-danger">*</span>
								<select class="form-control form-control-sm select2" name="bk_kota_tujuan" id="bk_kota_tujuan" style="width:100%;line-height:100px;" required>
									<option value="">Pilih Kota Tujuan</option>
									<?php foreach ($kota as $kt) { ?>
										<option value="<?= $kt->kec_nama . ', ' . $kt->kot_nama . ', ' . $kt->prov_nama ?>"><?= strtoupper($kt->kec_nama . ', ' . $kt->kot_nama . ', ' . $kt->prov_nama) ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Tipe Alamat</label> <span class="text-danger">*</span>
								<select class="form-control form-control-sm" name="bk_tipe_alamat" id="bk_tipe_alamat" style="width:100%;line-height:100px;" required>
									<option value="">Pilih Tipe Alamat</option>
									<?php foreach ($tipealamat as $ta) { ?>
										<option value="<?= $ta->ta_id ?>"><?= $ta->ta_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<hr size="2" width="100%">
						<div class="col-lg-12">
							<h4><b>Detail Barang</b></h4>
							<div class="form-group">
								<table class="table">
									<tr>
										<th>
											<label>Tipe Komoditas</label> <span class="text-danger">*</span>
										</th>
										<th>
											<label>Estimasi Harga Barang</label> <span class="text-danger">*</span>
										</th>
										<th>
											<label>Ongkos Kirim</label> <span class="text-danger">*</span>
										</th>
									</tr>
									<tr>
										<td>
											<select class="form-control form-control-sm" name="bk_tipe_komoditas" id="bk_tipe_komoditas" style="width:80%; line-height:100px;" required>
												<option value="">Pilih Tipe Komoditas</option>
												<?php foreach ($tipekomoditas as $tk) { ?>
													<option value="<?= $tk->tk_id ?>"><?= strtoupper($tk->tk_nama) ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<div class="input-group input-group-sm mb-3" style="width:80%;">
												<div class="input-group-prepend">
													<span class="input-group-text">Rp. </span>
												</div>
												<input type="number" min="0" class="form-control" name="bk_harga_barang" id="bk_harga_barang" required>
											</div>
										</td>
										<td>
											<div class="input-group input-group-sm mb-3" style="width:80%;">
												<div class="input-group-prepend">
													<span class="input-group-text">Rp. </span>
												</div>
												<input type="number" min="0" class="form-control" name="bk_biaya" id="bk_biaya" required>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<table class="table">
									<tr id="dynamic_field"></tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="col-lg-12" style="float:right;">
						<button type="submit" id="bk_simpan" class="btn btn-dark" style="float: right;"><i class="fas fa-check-circle"></i> Buat Booking</button>
					</div>
				</div>
			</form>
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

	$("#frm_booking").submit(function(e) {
		e.preventDefault();
		$("#bk_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "simpan",
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
							window.open("<?= base_url('Booking/cetak_resi/') ?>", "_blank");
							window.location.href = "<?= base_url('Booking/riwayat') ?>";
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

	function reset_form() {
		$("#bk_id").val(0);
		$("#frm_booking")[0].reset();
	}

	$('.tgl').daterangepicker({
		locale: {
			format: 'DD/MM/YYYY'
		},
		showDropdowns: true,
		singleDatePicker: true,
		"autoApply": true,
		opens: 'left'
	});

	$('.select2').select2({
		className: "form-control"
	});

	var i = 1;

	function tambah() {
		i++;
		$('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added">' +
			`<td>` + i + `</td>
		<td><input type="decimal" id="bd_berat_barang` + i + `" name="bd_berat_barang[]" class="form-control"></td>
		<td class="input-group input-group mb-3">
							<input type="number" min="0" id="bd_panjang` + i + `" name="bd_panjang[]" class="form-control col-lg-2">
							<div class="input-group-prepend">
								<span class="input-group-text"> x </span>
							</div>
							<input type="number" min="0" id="bd_lebar` + i + `" name="bd_lebar[]" class="form-control col-lg-2">
							<div class="input-group-prepend">
								<span class="input-group-text"> x </span>
							</div>
							<input type="number" min="0" id="bd_tinggi` + i + `" name="bd_tinggi[]" class="form-control col-lg-2">
							<div class="input-group-prepend">
								<span class="input-group-text"> cm</span>
							</div>
						</td>` +
			'<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fas fa-minus-circle"></i></button></td></tr>');
	}
	// <td><input type="number" id="bd_berat_volume` + i + `" name="bd_berat_volume[]" class="form-control"></td> ` +

	$(document).on('click', '.btn_remove', function() {
		var button_id = $(this).attr("id");
		$('#row' + button_id + '').remove();
	});

	function nilai() {
		i = 1;
		// <th>Berat Volume <small class="text-secondary">(Kg)</small></th>
		$("#dynamic_field").html(`<tr>
		<th>No</th>
		<th>Berat Barang <small class="text-secondary">(Kg)</small> <span class="text-danger">*</span></th>
		<th>Dimensi/Paket <small class="text-secondary">(P x L x T)</small> <span class="text-danger">*</span></th>
		</tr>
		<tr>
		<td>` + i + `</td>
		<td><input type="decimal" id="bd_berat_barang" name="bd_berat_barang[]" class="form-control"></td>
		<td class="input-group input-group mb-3">
							<input type="number" min="0" id="bd_panjang" name="bd_panjang[]" class="form-control col-lg-2">
							<div class="input-group-prepend">
								<span class="input-group-text"> x </span>
							</div>
							<input type="number" min="0" id="bd_lebar" name="bd_lebar[]" class="form-control col-lg-2">
							<div class="input-group-prepend">
								<span class="input-group-text"> x </span>
							</div>
							<input type="number" min="0" id="bd_tinggi" name="bd_tinggi[]" class="form-control col-lg-2">
							<div class="input-group-prepend">
								<span class="input-group-text"> cm</span>
							</div>
						</td>
						<td><button type="button" name="add" id="add" onclick="tambah()" class="btn btn-dark"><i class="fas fa-plus-circle"></button></td>		
						</tr>`);
	}
	// <td><input type="text" id="bd_berat_volume" name="bd_berat_volume[]" class="form-control"></td>

	function reset_form() {
		nilai();
	}

	$(document).ready(function() {
		nilai();
	});
</script>