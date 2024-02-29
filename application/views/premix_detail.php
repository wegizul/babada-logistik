<input type="hidden" name="pmx_id" id="pmx_id" value="<?= $pmx_id ?>">
<div class="inner">
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<a href="javascript:window.history.back()" class="btn btn-dark btn-sm" style="width: 100%"><i class="fa fa-reply"></i> &nbsp;Kembali</a>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<a href="javascript:tambah()" class="btn btn-dark btn-block btn-sm"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
							</div>
						</div>
					</div>
					Detail <?= $premix->pmx_nama ?>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-premix_detail" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Item</th>
								<th>Qty</th>
								<th>HPP</th>
								<th>Harga</th>
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

<div class="modal fade" id="modal_premix_detail" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cube"></i> Form Isi Premix</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-md" name="TambahEdit" id="frm_premix_detail">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="pxd_id" name="pxd_id" value="">
						<input type="hidden" name="pxd_pmx_id" id="pxd_pmx_id" value="<?= $pmx_id ?>">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Nama Item</label>
								<select class="form-control select2" name="pxd_mtl_id" id="pxd_mtl_id" style="width:100%;line-height:100px;" required>
									<option value="">Pilih</option>
									<?php foreach ($material as $m) { ?>
										<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<label>Qty</label>
							<div class="input-group">
								<input type="number" min="0" class="form-control" name="pxd_qty" id="pxd_qty" required>
								<div class="input-group-prepend">
									<span class="input-group-text">gram</span>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<label>HPP</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp. </span>
								</div>
								<input type="number" min="0" class="form-control" name="pxd_hpp" id="pxd_hpp" required>
							</div>
						</div>
						<!-- <div class="col-lg-6">
							<label>Harga</label>
							<div class="input-group col-lg">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp. </span>
								</div>
								<input type="number" min="0" class="form-control" name="pxd_harga" id="pxd_harga" required>
							</div>
						</div> -->
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="pxd_simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
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

<!-- Select 2 -->
<script src="<?= base_url("assets"); ?>/plugins/select2/js/select2.full.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<script>
	var save_method;
	var table;
	var pmx_id = $("#pmx_id").val();

	function drawTable() {
		$('#tabel-premix_detail').DataTable({
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
				"url": "../ajax_list_premix_detail/" + pmx_id,
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

	function tambah() {
		$("#pxd_id").val(0);
		$("frm_premix_detail").trigger("reset");
		$('#modal_premix_detail').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_premix_detail").submit(function(e) {
		e.preventDefault();
		$("#pxd_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "../simpan",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					reset_form();
					$("#modal_premix_detail").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#pxd_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#pxd_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function hapus_premix_detail(id) {
		event.preventDefault();
		$("#pxd_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_premix_detail(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "../cari",
			data: "pxd_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_premix_detail").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#pxd_id").val(0);
		$("#frm_premix_detail")[0].reset();
	}

	$("#yaKonfirm").click(function() {
		var id = $("#pxd_id").val();
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
					toastr.error(res.desc + "[" + res.err + "]");
				}
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
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