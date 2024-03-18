<div class="container">
	<div class="row">
		<?= $this->session->flashdata('error'); ?>
		<div class="card card-dark">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-cart-plus fa-sm"></i> Pembelian / Barang Masuk</h3>
			</div>
			<form role="form col-lg" name="Pembelian" id="frm_pembelian">
				<div class="card-body form">
					<div class="row">
						<input type="hidden" id="pbl_id" name="pbl_id" value="">
						<hr size="2" width="100%">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Supplier</label> <span class="text-danger">*</span>
								<select class="form-control select2" name="pbl_supplier" id="pbl_supplier" style="width:100%;line-height:100px;" required>
									<option value="">Pilih Supplier</option>
									<?php foreach ($supplier as $s) { ?>
										<option value="<?= $s->spl_nama ?>"><?= strtoupper($s->spl_nama) ?></option>
									<?php } ?>
								</select>
							</div>
							<label>Nomor Faktur</label> <span class="text-danger">*</span>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-receipt"></i></span>
								</div>
								<input type="text" class="form-control" name="pbl_no_faktur" id="pbl_no_faktur" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-6">
							<label>Tanggal</label> <span class="text-danger">*</span>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control" name="pbl_tanggal" id="pbl_tanggal" autocomplete="off" required>
							</div>
							<label>Total Harga</label> <span class="text-danger">*</span>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="number" min="0" class="form-control" name="pbl_total_harga" id="pbl_total_harga" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-12" style="margin-top: 20px;">
							<h5><b>Detail Barang</b></h5>
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
						<button type="submit" id="pbl_simpan" class="btn btn-dark" style="float: right;"><i class="fas fa-check-circle"></i> Simpan</button>
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

	$("#frm_pembelian").submit(function(e) {
		$("#pbl_id").val(0);
		e.preventDefault();
		$("#pbl_simpan").html("Menyimpan...");
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
							window.location.href = "<?= base_url('Pembelian/riwayat') ?>";
						} else {}
					})
				} else {
					toastr.error(res.desc);
				}
				$("#pbl_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#pbl_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

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
			`<td><select id="pbd_mtl_id` + i + `" name="pbd_mtl_id[]" class="form-control select2">
					<option value="">Pilih Item</option>
					<?php foreach ($material as $m) { ?>
						<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
					<?php } ?>
				</select>
			</td>
			<td>
				<input type="number" min="0" id="pbd_qty` + i + `" name="pbd_qty[]" class="form-control">
			</td>
			<td><select id="pbd_smt_id` + i + `" name="pbd_smt_id[]" class="form-control">
					<option value="">Pilih Satuan</option>
					<?php foreach ($satuan_material as $sm) { ?>
						<option value="<?= $sm->smt_id ?>"><?= $sm->smt_nama ?></option>
					<?php } ?>
				</select>
			</td>
			<td class="input-group input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Rp</span>
				</div>
				<input type="number" min="0" id="pbd_harga` + i + `" name="pbd_harga[]" class="form-control">
			</td>
			<td>
			<button type="button" name="remove" id="` + i + `" class="btn btn-danger btn_remove btn-xs"><i class="fas fa-minus-circle"></i></button></td>` +
			'</tr>'
		);
	}

	$(document).on('click', '.btn_remove', function() {
		i--;
		var button_id = $(this).attr("id");
		$('#row' + button_id + '').remove();
	});

	function nilai() {
		$("#dynamic_field").html(`<tr>
			<th width="35%">Item <span class="text-danger">*</span></th>
			<th width="15%">Qty <span class="text-danger">*</span></th>
			<th width="15%">Satuan <span class="text-danger">*</span></th>
			<th width="25%">Harga <span class="text-danger">*</span></th>
			<td width="10%"><button type="button" name="add" id="add" onclick="tambah()" class="btn btn-dark btn-xs"><i class="fas fa-plus-circle"></i></button></td>
		</tr>
		<tr>
			<td><select class="form-control select2" id="pbd_mtl_id" name="pbd_mtl_id[]">
				<option value="">Pilih Item</option>
					<?php foreach ($material as $m) { ?>
						<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
					<?php } ?>
				</select>
			</td>
			<td>
				<input type="number" min="0" id="pbd_qty" name="pbd_qty[]" class="form-control">
			</td>
			<td><select id="pbd_smt_id" name="pbd_smt_id[]" class="form-control">
					<option value="">Pilih Satuan</option>
					<?php foreach ($satuan_material as $sm) { ?>
						<option value="<?= $sm->smt_id ?>"><?= $sm->smt_nama ?></option>
					<?php } ?>
				</select>
			</td>
			<td class="input-group input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Rp</span>
				</div>
				<input type="number" min="0" id="pbd_harga" name="pbd_harga[]" class="form-control">
			</td>	
		</tr>`);
	}

	function reset_form() {
		$("#pbl_id").val(0);
		$("#frm_pembelian")[0].reset();
		nilai();
	}

	$(document).ready(function() {
		nilai();
	});
</script>