<div class="container">
	<div class="row">
		<div class="card card-dark">
			<div class="card-header">
				<h3 class="card-title"><i class="fas fa-cart-plus fa-sm"></i> Pembelian / Barang Masuk</h3>
			</div>
			<form role="form col-lg" name="Pembelian" id="frm_pembelian">
				<div class="card-body form">
					<div class="row">
						<input type="hidden" id="pbl_id" name="pbl_id" value="">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Nama Supplier</label> <span class="text-danger">*</span>
								<select class="form-control form-control-sm select2" name="pbl_supplier" id="pbl_supplier" style="width:100%;line-height:100px;" required>
									<option value="">Pilih Supplier</option>
									<?php foreach ($supplier as $s) { ?>
										<option value="<?= $s->spl_nama ?>"><?= strtoupper($s->spl_nama) ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-3">
							<label>Nomor Faktur</label> <span class="text-danger">*</span>
							<div class="input-group input-group-sm">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-receipt"></i></span>
								</div>
								<input type="text" class="form-control form-control-sm" name="pbl_no_faktur" id="pbl_no_faktur" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-3">
							<label>Tanggal</label> <span class="text-danger">*</span>
							<div class="input-group input-group-sm mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control form-control-sm" name="pbl_tanggal" id="pbl_tanggal" autocomplete="off" required>
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
								<table class="table">
									<tr id="dynamic_field"></tr>
								</table>
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
								<input type="number" min="0" step="0.001" class="form-control form-control-sm" name="pbl_jumlah_harga" id="pbl_jumlah_harga" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-7 text-right">
							<label style="margin-right: 5px;">PPn 11%</label><input type="checkbox" id="ppn_true" value="" checked onchange="ppn()">
							<input type="hidden" id="val_ppn" name="ppn_true" value="">
						</div>
						<div class="col-lg-5">
							<div class="input-group input-group-sm" id="kolom_ppn">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="number" min="0" step="0.001" class="form-control form-control-sm" name="pbl_ppn" id="total_ppn" onchange="updateTotal()">
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
								<input type="number" min="0" class="form-control form-control-sm" name="pbl_ongkos_bongkar" id="pbl_ongkos_bongkar" onchange="updateTotal()">
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
								<input type="number" min="0" step="0.001" class="form-control form-control-sm" name="pbl_total_harga" id="pbl_total_harga">
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
	var i = 1;

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
			success: function(response) {
				var res = JSON.parse(response);
				if (res.status == 1) {
					swal('Sukses', res.desc, 'success').then((result) => {
						if (!result.isConfirmed) {
							window.location.href = "<?= base_url('Pembelian/laporan') ?>";
						}
					});
				} else {
					toastr.error(res.desc);
				}
				$("#pbl_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, status, errorThrown) {
				$("#pbl_simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error mendapatkan data dari server');
			}
		});
	});

	$('.tgl').daterangepicker({
		locale: {
			format: 'DD/MM/YYYY'
		},
		showDropdowns: true,
		singleDatePicker: true,
		autoApply: true,
		opens: 'left'
	});

	$('.select2').select2({
		className: "form-control"
	});

	function cari_material(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "cari_material",
			data: {
				mtl_id: id
			},
			dataType: "json",
			success: function(data) {
				tambah(data);
			}
		});
	}

	function tambah(val) {
		i++;
		$('#dynamic_field').append(`
        <tr id="row${i}" class="dynamic-added">
            <td width="45%">
                ${val.mtl_nama}
                <input type="hidden" id="pbd_mtl_id${i}" name="pbd_mtl_id[]" value="${val.mtl_id}" class="form-control form-control-sm" readonly>
            </td>
            <td width="15%">
                <input type="number" min="0" step="0.01" id="pbd_qty${i}" name="pbd_qty[]" class="form-control form-control-sm">
            </td>
            <td width="15%">
                <input type="text" id="pbd_satuan${i}" name="pbd_satuan[]" value="${val.smt_nama}" class="form-control form-control-sm" readonly>
            </td>
            <td width="20%" class="input-group input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text input-group-sm">Rp</span>
                </div>
                <input type="number" min="0" step="0.01" id="pbd_harga${i}" name="pbd_harga[]" class="form-control form-control-sm" onchange="total()">
            </td>
            <input type="hidden" id="pbd_ppn${i}" name="pbd_ppn[]" value="" class="form-control form-control-sm">
            <td><span name="remove" id="${i}" class="btn_remove"><i class="fas fa-trash-alt"></i></span></td>
        </tr>
    `);
	}

	$(document).on('click', '.btn_remove', function() {
		var button_id = $(this).attr("id");
		$('#row' + button_id).remove();
		total(); // Update total after removal
		i--; // Move this after removal to avoid issues
	});

	function total() {
		var harga = 0; // Inisialisasi variabel harga
		for (var x = 1; x <= i; x++) { // Gunakan x untuk perulangan
			var itemHarga = parseFloat($("#pbd_harga" + x).val()) || 0;
			harga += itemHarga;

			// Hitung PPN untuk setiap item
			var ppn = (itemHarga * 11) / 100;
			$('#pbd_ppn' + x).val(ppn.toFixed(2));
		}

		// Update total harga
		var jumlah = $('#pbl_jumlah_harga').val() || 0;
		jumlah = parseFloat(jumlah);

		var total_harga = parseFloat(harga);
		$('#pbl_jumlah_harga').val(total_harga.toFixed(2));

		// Hitung dan perbarui total PPN
		var ppn_checkbox = $("#ppn_true").is(":checked");

		var total_ppn = (total_harga * 11) / 100;
		total_ppn = parseFloat(total_ppn);
		var total_harga = $('#pbl_total_harga').val() || 0;
		total_harga = parseFloat(total_harga);

		if (ppn_checkbox) {
			$('#val_ppn').val(1);
			$('#kolom_ppn').show();
			$('#total_ppn').val(total_ppn.toFixed(2));
			$('#pbl_total_harga').val((total_harga + total_ppn).toFixed(2));
		} else {
			$('#val_ppn').val(0);
			$('#kolom_ppn').hide();
			$('#total_ppn').val(0);
			$('#pbl_total_harga').val((total_harga - total_ppn).toFixed(2));
		}

		updateTotal();
	}

	function ppn() {
		// Hitung dan perbarui total PPN
		var ppn_checkbox = $("#ppn_true").is(":checked");

		var total_harga = $('#pbl_jumlah_harga').val() || 0;
		var total_ppn = (total_harga * 11) / 100;
		total_ppn = parseFloat(total_ppn);
		var total_harga = $('#pbl_total_harga').val() || 0;
		total_harga = parseFloat(total_harga);

		if (ppn_checkbox) {
			$('#val_ppn').val(1);
			$('#kolom_ppn').show();
			$('#total_ppn').val(total_ppn.toFixed(2));
			$('#pbl_total_harga').val((total_harga + total_ppn).toFixed(2));
		} else {
			$('#val_ppn').val(0);
			$('#kolom_ppn').hide();
			$('#total_ppn').val(0);
			$('#pbl_total_harga').val((total_harga - total_ppn).toFixed(2));
		}
	}

	function updateTotal() {
		var jumlah = parseFloat($('#pbl_jumlah_harga').val()) || 0;
		var ppn = parseFloat($('#total_ppn').val()) || 0;
		var ongkos_bongkar = parseFloat($('#pbl_ongkos_bongkar').val()) || 0;

		var total = jumlah + ppn - ongkos_bongkar;
		$('#pbl_total_harga').val(total.toFixed(2));
	}

	function reset_form() {
		$("#pbl_id").val(0);
		$("#frm_pembelian")[0].reset();
	}

	$(document).ready(function() {});
</script>