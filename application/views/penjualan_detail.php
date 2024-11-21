<input type="hidden" name="pjl_id" id="pjl_id" value="<?= $pjl_id ?>">
<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<a href="javascript:window.history.back()" class="btn btn-dark btn-sm"><i class="fa fa-reply"></i> &nbsp;Kembali</a>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
							    <a href="javascript:add_item()" class="btn btn-dark btn-block btn-sm"><i class="fa fa-plus-circle"></i> &nbsp; Tambah Item</a>
							</div>
						</div>
					</div>
					Detail Penjualan #<?= $faktur->pjl_faktur ?>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-penjualan-detail" width="100%" style="font-size:90%;">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Item</th>
								<th>Qty</th>
								<th>Satuan</th>
								<th>Harga</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="3" align="center">Tidak ada data</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_konfirm" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Konfirmasi klaim ini</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_konfirm">
				<div class="modal-body form">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<textarea rows="3" class="form-control" name="rjt_keterangan" id="rjt_keterangan" disabled></textarea>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<input type="hidden" name="pjd_id" id="pjd_id" value="">
								<input type="hidden" name="pjd_pjl_id" id="pjd_pjl_id" value="">
								<select class="form-control" name="pjd_status" id="pjd_status">
									<option value="6">Konfirmasi Klaim</option>
									<option value="3">Tolak Klaim</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_penjualan_detail" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-edit"></i> Edit</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_edit">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" class="form-control" name="pjd_id" id="pjd_id2">
						<input type="hidden" class="form-control" name="pjd_pjl_id" id="pjd_pjl_id2">
						<div class="col-lg-5">
							<label>Quantity</label>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input type="text" class="form-control" name="pjd_qty" id="pjd_qty">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<select class="form-control" id="pjd_smt_id" name="pjd_smt_id">
									<option id="smt_terpilih" value=""></option>
									<?php foreach ($satuan as $smt) { ?>
										<option value="<?= $smt->smt_id ?>"><?= $smt->smt_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-5">
							<label>Harga</label>
						</div>
						<div class="col-lg-7">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="text" id="pjd_harga" name="pjd_harga" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="update" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Edit</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_add_item" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-edit"></i> Tambah Item</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_add_item">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" class="form-control" name="pjd_id" id="pjd_id3">
						<input type="hidden" class="form-control" name="pjd_pjl_id" id="pjd_pjl_id3">
						<div class="col-lg-5">
							<label>Pilih Item</label>
						</div>
						<div class="col-lg-7">
							<div class="form-group">
								<select class="form-control select2" name="pjd_mtl_id" id="pjd_mtl_id" style="width: 100%;">
									<option value="">Pilih Item</option>
									<?php foreach ($material as $m) { ?>
										<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-5">
							<label>Quantity</label>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<input type="number" min="0" step="0.001" class="form-control" name="pjd_qty" id="pjd_qty3">
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<select class="form-control" id="pjd_smt_id3" name="pjd_smt_id">
									<option id="smt_terpilih" value="">Pilih</option>
									<?php foreach ($satuan as $smt) { ?>
										<option value="<?= $smt->smt_id ?>"><?= $smt->smt_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-5">
							<label>Harga</label>
						</div>
						<div class="col-lg-7 mb-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="number" min="0" step="0.001" id="pjd_harga3" name="pjd_harga" class="form-control">
							</div>
						</div>
						<div class="col-lg-5">
							<label>Status</label>
						</div>
						<div class="col-lg-7">
							<div class="form-group">
								<select class="form-control" name="pjd_status" id="pjd_status">
									<option value="1">Tersedia</option>
									<option value="2">Dikonfirmasi Logistik</option>
									<option value="3">Dikirim</option>
									<option value="4">Selesai</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="simpan_add" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Tambahkan</button>
				</div>
			</form>
		</div>
	</div>
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

<!-- Sweet alert -->
<script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<!-- Select 2 -->
<script src="<?= base_url("assets"); ?>/plugins/select2/js/select2.full.js"></script>

<script>
	var save_method;
	var table;
	var pjl_id = $("#pjl_id").val();
	$('#pjd_pjl_id').val(pjl_id);
	$('#pjd_pjl_id2').val(pjl_id);
	$('#pjd_pjl_id3').val(pjl_id);

	function drawTable() {
		$('#tabel-penjualan-detail').DataTable({
			"destroy": true,
			lengthMenu: [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			buttons: [],
			"responsive": true,
			"sort": true,
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": "../ajax_list_penjualan_detail/" + pjl_id,
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [-1],
				"orderable": false,
			}, ],
			"initComplete": function(settings, json) {
				$("#process").html("Process...")
				$(".btn").attr("disabled", false);
				$("#isidata").fadeIn();
			}
		});
	}

	function hapus_penjualan_detail(id) {
		event.preventDefault();
		$("#pjd_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function edit(id) {
		$("#pjd_id2").val(id);
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../cari",
			data: "pjd_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == 'smt_nama') {
						$("#smt_terpilih").val(dt[1]);
					} else {
						$("#" + dt[0]).val(dt[1]);
					}
				});
				$(".inputan").attr("disabled", false);
				$("#modal_penjualan_detail").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	$("#frm_edit").submit(function(e) {
		e.preventDefault();
		$("#update").html("Menyimpan...");
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
					toastr.success(res.desc);
					drawTable();
					$("#modal_penjualan_detail").modal("hide");
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#update").html("<i class='fas fa-check-circle'></i> Edit");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#update").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function reset_form() {
		$("#pjd_id").val(0);
		$("#frm_penjualan_detail").trigger("reset");
		$("#frm_add_item").trigger("reset");
	}

	$("#yaKonfirm").click(function() {
		var id = $("#pjd_id").val();
		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "../hapus/" + id,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#frmKonfirm").modal("hide");
					drawTable();
				} else {
					toastr.error(res.desc);
				}
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	});

	function tolak(pjl, pjd) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../tolak/" + pjl + "/" + pjd,
			success: function(data) {
				var res = JSON.parse(data);
				if (res.status == 1) {
					Swal.fire(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {
							drawTable();
						} else {}
					})
				} else {
					toastr.error(res.desc);
				}
				return false;
			}
		});
	}

	function getKlaim(pjd) {
		event.preventDefault();
		$.ajax({
			type: "GET",
			url: "../get_klaim/" + pjd,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				return false;
			}
		});
	}

	function konfirmasi(id) {
		getKlaim(id);
		$("#pjd_id").val(id);
		$("frm_konfirm").trigger("reset");
		$('#modal_konfirm').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_konfirm").submit(function(e) {
		e.preventDefault();
		$("#simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "../konfirm_klaim",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					$("#modal_konfirm").modal("hide");
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function ubahQty(pjl, pjd, qty) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../ubah_qty/" + pjl + "/" + pjd + "/" + qty,
			success: function(data) {
				var res = JSON.parse(data);
				if (res.status == 1) {
					toastr.success(res.desc);
				} else {
					toastr.error(res.desc);
				}
				return false;
			}
		});
	}

	function ubahHrg(pjl, pjd, qty) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../ubah_harga/" + pjl + "/" + pjd + "/" + qty,
			success: function(data) {
				var res = JSON.parse(data);
				if (res.status == 1) {
					toastr.success(res.desc);
				} else {
					toastr.error(res.desc);
				}
				return false;
			}
		});
	}

	function add_item() {
		$("#pjd_id3").val(0);
		$("frm_add_item").trigger("reset");
		$('#modal_add_item').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_add_item").submit(function(e) {
		e.preventDefault();
		$("#simpan_add").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "../add_item",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					$("#modal_add_item").modal("hide");
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#simpan_add").html("<i class='fas fa-check-circle'></i> Tambahkan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan_add").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	$('.select2').select2({
		className: "form-control"
	});

	$(document).ready(function() {
		drawTable();
	});
</script>