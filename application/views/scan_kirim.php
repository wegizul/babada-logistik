<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-dark">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-barcode fa-sm"></i> Scan Kirim</h3>
				</div>
				<div class="card-body form">
					<div class="row">
						<div class="col-lg-5">
							<label>Masukan Nomor Resi</label><br>
							<span id="error"></span>
						</div>
						<div class="col-lg-3">
							<label>Tujuan</label><br>
							<span id="error_tujuan"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-5">
							<input type="text" name="kode" id="kode" class="form-control" oninput="get_resi()" autofocus required>
						</div>
						<div class="col-lg-5">
							<select name="tr_tujuan" id="tujuan" class="form-control select2" onchange="get_resi()" required>
								<option value="">Pilih</option>
								<?php $ket = "";
								foreach ($tujuan as $t) {
									switch ($t->log_level) {
										case 3:
											$ket = "POS";
											break;
										case 4:
											$ket = "HUB";
											break;
										case 5:
											$ket = "SUBHUB";
											break;
									};
								?>
									<option value=<?= $t->log_id ?>><?= $ket . ' ' . $t->log_agen ?></option>
								<?php } ?>
							</select>
						</div>
						<hr size="2" width="100%">
						<div class="col-lg-7">
							<a href="javascript:manifest()" class="btn btn-dark btn-sm" style="float:right;"><i class="fas fa-plus-circle"></i> Buat Manifest</a>
							<table class="table table-striped table-bordered table-hover" id="tabel-data" width="100%" style="font-size:90%;">
								<thead>
									<tr>
										<th>Waktu Scan</th>
										<th>Nomor Resi</th>
										<th>Status</th>
										<th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="3" align="center">Tidak ada data</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-lg-5">
							<i class="fa fa-circle-chevron-down"></i> <label style="margin-bottom: 20px;">Rincian Manifest</label>
							<table class="table table-striped table-bordered table-hover" id="tabel-data" width="100%" style="font-size:90%;">
								<thead>
									<tr>
										<th>Kode Manifest</th>
										<th>Nama Kurir</th>
										<th>Cetak</th>
									</tr>
								</thead>
								<tbody>
									<?php if ($manifest) {
										foreach ($manifest as $m) { ?>
											<tr>
												<td><?= $m->mf_kode ?></td>
												<td><?= $m->mf_kurir ?></td>
												<td><a href="<?= base_url('ScanKirim/cetak_manifest/' . $m->mf_kode) ?>" class="btn btn-warning btn-sm" target="_blank"><i class="fas fa-print"></i> </a> </td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="3" align="center">Tidak ada data</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="card-footer">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_manifest" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cube"></i> Form Manifest</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_manifest">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="mf_id" name="mf_id" value="">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Nama Kurir</label>
								<input type="text" class="form-control" name="mf_kurir" id="mf_kurir" required>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Notelp Kurir</label>
								<input type="number" min="0" class="form-control" name="mf_telp_kurir" id="mf_telp_kurir">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Nomor Kendaraan</label>
								<input type="text" class="form-control" name="mf_nopol" id="mf_nopol">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="simpan" class="btn btn-dark"><i class="fas fa-check-circle"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row">

</div>

<!-- DataTables -->
<script src="<?= base_url("assets"); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.colVis.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/pdfmake.min.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/vfs_fonts.js"></script>
<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/jszip.min.js"></script>

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
	function drawTable() {
		$('#tabel-data').DataTable({
			"destroy": true,
			lengthMenu: [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			buttons: [],
			"responsive": true,
			"sort": false,
			"processing": true,
			"serverSide": true,
			"searching": false,
			"order": [],
			"ajax": {
				"url": "ajax_list_tracking/",
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [-1],
				"orderable": false,
			}, ],
			"initComplete": function(settings, json) {
				$("#process").html("<i class='glyphicon glyphicon-search'></i> Process")
				$("#isidata").fadeIn();
			}
		});
	}

	function manifest() {
		reset_form();
		$("#mf_id").val(0);
		$("frm_manifest").trigger("reset");
		$('#modal_manifest').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_manifest").submit(function(e) {
		e.preventDefault();
		$("#simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "simpan_manifest",
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
							drawTable();
							reset_form();
							$("#modal_manifest").modal("hide");
							window.location.reload();
						} else {}
					})
				} else {
					Swal.fire(
						'Gagal',
						res.desc,
						'error'
					).then((result) => {
						if (!result.isConfirmed) {
							drawTable();
							reset_form();
							$("#modal_manifest").modal("hide");
						} else {}
					})
				}
				$("#simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function simpan(data, tujuan) {
		$.ajax({
			type: "POST",
			url: "simpan",
			data: {
				bd_kode: data,
				tr_tujuan: tujuan
			},
			dataType: "json",
			success: function(res) {
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					reset_form();
				} else {
					toastr.error(res.desc);
				}
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});

		$('#kode').attr('autofocus');
	}

	function get_resi() {
		var kode = $('#kode').val();
		var bd_kode = decodeURIComponent(kode);
		var tujuan = $('#tujuan').val();
		$.get("get_resi/" + bd_kode, {}, function(data) {
			if (data) {
				$('#error').html('');
				if (tujuan == "") {
					$('#error_tujuan').html('<small style="color: red;"><i>Tujuan Harus Dipilih</i></small>');
				} else {
					$('#error_tujuan').html('');
					simpan(data, tujuan);
				}
			} else {
				$('#error').html('<small style="color: red;"><i>Nomor Resi Tidak Ditemukan</i></small>');
			}
		});
	}

	function reset_form() {
		$("#kode").val('');
	}

	$('.select2').select2({
		className: "form-control"
	});

	$(document).ready(function() {
		drawTable();
	});
</script>