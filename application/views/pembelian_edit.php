<div class="container">
	<div class="row">
		<div class="card card-dark">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-cart-plus fa-sm"></i> Edit Pembelian / Barang Masuk</h3>
			</div>
			<form role="form col-lg" name="Pembelian" id="frm_pembelian">
				<div class="card-body form">
					<div class="row">
						<input type="hidden" id="pbl_id" name="pbl_id" value="<?= $inv->pbl_id ?>">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Supplier</label> <span class="text-danger">*</span>
								<input type="text" class="form-control form-control-sm" name="pbl_supplier" id="pbl_supplier" value="<?= $inv->pbl_supplier ?>" readonly>
							</div>
						</div>
						<div class="col-lg-3">
							<label>Nomor Faktur</label> <span class="text-danger">*</span>
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-receipt"></i></span>
								</div>
								<input type="text" class="form-control form-control-sm" name="pbl_no_faktur" id="pbl_no_faktur" value="<?= $inv->pbl_no_faktur ?>">
							</div>
						</div>
						<div class="col-lg-3">
							<label>Tanggal</label> <span class="text-danger">*</span>
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control form-control-sm" name="pbl_tanggal" id="pbl_tanggal" value="<?= $inv->pbl_tanggal ?>">
							</div>
						</div>
						<div class="col-lg-4" style="margin-top: 20px;">
							<h5><b>Detail Barang</b></h5>
						</div>
						<div class="col-lg-8" style="margin-top: 20px;">
							<select class="form-control select2" onChange="cari_material(this.value)" autofocus>
								<option value="">Pilih Item</option>
								<?php foreach ($material as $m) { ?>
									<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-lg-12" style="margin-top: 20px;">
							<div class="form-group">
								<table class="table">
									<tr>
										<th width="45%">Item <span class="text-danger">*</span></th>
										<th width="15%">Qty <span class="text-danger">*</span></th>
										<th width="15%">Satuan <span class="text-danger">*</span></th>
										<th width="20%">Harga <span class="text-danger">*</span></th>
										<th></th>
									</tr>
								</table>
								<div style="overflow: scroll; height:400px;">
									<input type="hidden" id="parameter" name="parameter" value="" class="form-control form-control-sm">

									<table class="table" id="item">
									</table>
									<table class="table">
										<tr id="dynamic_field"></tr>
									</table>
								</div>
							</div>
						</div>
						<div class="col-lg-7 text-right">
							<label>Jumlah</label> <span class="text-danger">*</span>
						</div>
						<div class="col-lg-5">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="number" min="0" step="0.001" class="form-control form-control-sm" name="pbl_jumlah_harga" id="pbl_jumlah_harga" value="<?= $inv->pbl_jumlah_harga ?>" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-7 text-right">
							<label style="margin-right: 5px;">PPn 11%</label><input type="checkbox" id="ppn_true" value="" onchange="ppn()">
							<input type="hidden" id="val_ppn" name="ppn_true" value="<?= $inv->ppn_true ?>">
						</div>
						<div class="col-lg-5">
							<div class="input-group input-group-sm" id="kolom_ppn" style="display: none;">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="number" min="0" step="0.001" class="form-control form-control-sm" name="pbl_ppn" id="total_ppn" value="<?= $inv->pbl_ppn ?>" onchange="ppn(this.value)">
							</div>
						</div>
						<div class="col-lg-7 text-right">
							<label>Ongkos Bongkar</label>
						</div>
						<div class="col-lg-5">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="number" min="0" class="form-control form-control-sm" name="pbl_ongkos_bongkar" id="pbl_ongkos_bongkar" value="<?= $inv->pbl_ongkos_bongkar ?>" onchange="ongkos_bongkar(this.value)">
								<input type="hidden" class="form-control form-control-sm" id="pbl_ongkos_bongkar_lama" value="<?= $inv->pbl_ongkos_bongkar ?>">
							</div>
						</div>
						<div class="col-lg-7 text-right">
							<label>Total</label>
						</div>
						<div class="col-lg-5">
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="number" min="0" step="0.001" class="form-control form-control-sm" name="pbl_total_harga" id="pbl_total_harga" value="<?= $inv->pbl_total_harga ?>">
								<input type="hidden" class="form-control form-control-sm" id="pbl_total_harga_lama" value="<?= $inv->pbl_total_harga ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="col-lg-12" style="float:right;">
						<button type="submit" id="pbl_simpan" class="btn btn-dark" style="float: right;"><i class="fas fa-check-circle"></i> Simpan</button>
						<a href="javascript:window.history.back()" type="button" class="btn btn-dark mr-2" style="float: right;"><i class="fas fa-reply"></i> Kembali</a>
					</div>
				</div>
			</form>
		</div>
	</div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- jquery mask -->
<script src="<?= base_url(); ?>assets/jquery-mask/dist/jquery.mask.min.js"></script>

<!-- Custom Java Script -->
<script>
	var save_method; //for save method string
	var table;
	var id_pembelian = $('#pbl_id').val();

	document.addEventListener('DOMContentLoaded', function() {
		$('#item').html('')
		event.preventDefault();
		$.ajax({
			type: "GET",
			url: "<?= base_url('Pembelian/getPembelian/') ?>" + id_pembelian,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.forEach((dt) => {
					$("#item").append(dt[1]);
				});
				return false;
			}
		});
	});

	$("#frm_pembelian").submit(function(e) {
		e.preventDefault();
		$("#pbl_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "../simpan_edit",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					swal(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {
							window.location.href = "<?= base_url('Pembelian/laporan') ?>";
						} else {}
					})
				} else {
					toastr.error(res.desc);
				}
				$("#pbl_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#pbl_simpan").html("Error");
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

	function cari_material(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../cari_material",
			data: "mtl_id=" + id,
			dataType: "json",
			success: function(data) {
				tambah(data);
				return false;
			}
		});
	}

	var i = 1;
	$('#parameter').val(i);

	function tambah(val) {
		i++;
		$('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added">' +
			`<td width="45%">
				` + val.mtl_nama + `
				<input type="hidden" id="pbd_mtl_id` + i + `" name="pbd_mtl_id[]" value="` + val.mtl_id + `" class="form-control form-control-sm" readonly>
			</td>
			<td width="15%">
				<input type="number" min="0" step="0.01" id="pbd_qty` + i + `" name="pbd_qty[]" class="form-control form-control-sm">
			</td>
			<td width="15%">
				<input type="text" id="pbd_satuan` + i + `" name="pbd_satuan[]" value="` + val.smt_nama + `" class="form-control form-control-sm" readonly>
			</td>
			<td width="20%" class="input-group input-group input-group-sm">
				<div class="input-group-prepend">
					<span class="input-group-text input-group-sm">Rp</span>
				</div>
				<input type="number" min="0" step="0.01" id="pbd_harga` + i + `" name="pbd_harga[]" class="form-control form-control-sm" onchange="total(this.value,` + i + `)">
			</td>
			<input type="hidden" id="pbd_ppn` + i + `" name="pbd_ppn[]" value="" class="form-control form-control-sm">
			<td>
			<span name="remove" id="` + i + `" class="btn_remove"><i class="fas fa-trash-alt"></i></span></td>` +
			'</tr>'
		);
	    $('#parameter').val(i);
	}

	$(document).on('click', '.btn_remove', function() {
		i--;
		$('#parameter').val(i);
		var button_id = $(this).attr("id");
		$('#row' + button_id + '').remove();
	});

	function total(harga, idx) {
		var jumlah = $('#pbl_jumlah_harga').val();
		var jumlah_harga = (Number(jumlah) + Number(harga));
		$('#pbl_jumlah_harga').val(jumlah_harga);

		var jml_ppn = (harga * 11) / 100;
		var ppn = $('#pbd_ppn' + idx).val(jml_ppn);

		var tot_ppn = $('#total_ppn').val();
		var total_ppn = Number(jml_ppn) + Number(tot_ppn);
		$('#total_ppn').val(total_ppn);

		var totall = $('#pbl_total_harga').val();
		var total_harga = (Number(totall) + Number(harga)) + jml_ppn;
		$('#pbl_total_harga').val(total_harga);
	}

	function ongkos_bongkar(ob) {
		var totall = $('#pbl_total_harga').val();
		var total_lama = $('#pbl_total_harga_lama').val();
		var ob_lama = $('#pbl_ongkos_bongkar_lama').val();
		if (Number(ob) > Number(ob_lama)) {
			var selisih = Number(ob) - Number(ob_lama);
			var total_harga = Math.round(Number(totall)) - selisih;
			$('#pbl_total_harga').val(total_harga);
		} else if (Number(ob) < Number(ob_lama)) {
			var selisih = Number(ob_lama) - Number(ob);
			var total_harga = Math.round(Number(totall)) + selisih;
			$('#pbl_total_harga').val(total_harga);
		} else {
			$('#pbl_total_harga').val(total_lama);
		}
	}

	var val_ppn = $('#val_ppn').val();
	if (val_ppn == 1) {
		$('#ppn_true').attr("checked", "checked");
		$('#kolom_ppn').show();
	}

	function ppn() {
		var x = $("#ppn_true").is(":checked");
		var ppn = $('#total_ppn').val();
		var totall = $('#pbl_total_harga').val();
		
		if (x === true) {
			$('#val_ppn').val(1);
			$('#kolom_ppn').show();
			var total_harga = Number(totall) + Number(ppn);
			$('#pbl_total_harga').val(total_harga);
		} else {
			$('#val_ppn').val(0);
			$('#kolom_ppn').hide();
			var total_harga = Number(totall) - Number(ppn);
			$('#pbl_total_harga').val(total_harga);
		}
	}

	function ubah_qty(id, qty) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../editQty/" + id + "/" + qty,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					swal(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {} else {}
					})
				} else {
					toastr.error(res.desc);
				}
				return false;
			}
		});
	}

	function ubah_harga(id, harga) {
		var ppn = (harga * 11) / 100;
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../editHarga/" + id + "/" + harga + "/" + ppn,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					swal(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {
							window.location.reload();
						} else {}
					})
				} else {
					toastr.error(res.desc);
				}
				return false;
			}
		});
	}

	function hapus_item(id, pbl_id) {
		$.ajax({
			type: "GET",
			url: "../hapusItem/" + id + "/" + pbl_id,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					swal(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {
							window.location.reload();
						} else {}
					})
				} else {
					toastr.error(res.desc);
				}
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}

	function reset_form() {
		$("#pbl_id").val(0);
		$("#frm_pembelian")[0].reset();
	}

	$(document).ready(function() {});
</script>