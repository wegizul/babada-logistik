<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<span class="text-secondary" style="margin: 25px;"><i class="fas fa-home"></i> / <b class="text-dark"><?= $page ?></b></span>
			<div class="card mt-3">
				<div class="card-header">
					<div class="row">
						<div class="col-md-8 pl-0">
							<i class="fas fa-cube mb-3"></i> <?= $page ?>
						</div>
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<a href="javascript:tambah()" class="btn btn-dark btn-block btn-sm"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp; Premix Baru</a>
							</div>
						</div>
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<a href="javascript:stok_premix()" class="btn btn-dark btn-block btn-sm"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp; Stok Premix</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-data" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Nama Premix</th>
								<th>HPP</th>
								<th>Harga Jual</th>
								<th>Stok</th>
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

<div class="modal fade" id="modal_premix" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cube"></i> Form Premix</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-md" name="TambahEdit" id="frm_premix">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="pmx_id" name="pmx_id" value="">
						<div class="col-lg-8">
							<div class="form-group">
								<label>Nama Premix</label>
								<input type="text" class="form-control" name="pmx_nama" id="pmx_nama" required>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" name="pmx_status" id="pmx_status">
									<option value="1">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
							</div>
						</div>
						<div class="col-lg-8">
							<label>Harga Jual</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp. </span>
								</div>
								<input type="number" min="0" class="form-control" name="pmx_harga_jual" id="pmx_harga_jual" required>
							</div>
						</div>
						<!-- <div class="col-lg-4">
							<label>Stok</label>
							<div class="input-group">
								<input type="number" min="0" class="form-control" name="pmx_stok" id="pmx_stok">
								<div class="input-group-prepend">
									<span class="input-group-text"><small>Karung</small></span>
								</div>
							</div>
						</div> -->
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="pmx_simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_stokpremix" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cube"></i> Penyesuaian Stok Premix</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_stokpremix">
				<div class="modal-body form">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Nama Premix</label>
								<select class="form-control select2" name="pxs_pmx_id" id="pxs_pmx_id" style="width: 100%;" required>
									<option value="">Pilih</option>
									<?php foreach ($premix as $m) { ?>
										<option value="<?= $m->pmx_id ?>"><?= $m->pmx_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<label>Jumlah Item</label>
							<div class="input-group">
								<input type="number" min="0" class="form-control" name="pxs_qty" id="pxs_qty" required>
								<div class="input-group-prepend">
									<span class="input-group-text">Karung</span>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tipe Penyesuaian</label>
								<select class="form-control" name="pxs_tipe" id="pxs_tipe">
									<option value="1">Penambahan Stok</option>
									<option value="2">Pengurangan Stok</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="stok_simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
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

	function drawTable() {
		$('#tabel-data').DataTable({
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
			"searching": true,
			"order": [],
			"ajax": {
				"url": "ajax_list_premix/",
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
		$("#pmx_id").val(0);
		$("frm_premix").trigger("reset");
		$('#modal_premix').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_premix").submit(function(e) {
		e.preventDefault();
		$("#pmx_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "simpan",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					reset_form();
					$("#modal_premix").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#pmx_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#pmx_simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function hapus_premix(id) {
		event.preventDefault();
		$("#pmx_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_premix(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "cari",
			data: "pmx_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == "pmx_foto") {
						$("#preview").append('<img src="<?= base_url('assets/files/premix/') ?>' + dt[1] + '" width="100px">');
						$("#pmx_foto").val();
					} else {
						$("#" + dt[0]).val(dt[1]);
					}
				});
				$(".inputan").attr("disabled", false);
				$("#modal_premix").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function stok_premix() {
		$("#pmx_id").val(0);
		$("frm_stokpremix").trigger("reset");
		$('#modal_stokpremix').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_stokpremix").submit(function(e) {
		e.preventDefault();
		$("#stok_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "stok_premix",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					reset_form();
					$("#modal_stokpremix").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#stok_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#stok_simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function reset_form() {
		$("#pmx_id").val(0);
		$("#frm_premix")[0].reset();
		$("#frm_stokpremix")[0].reset();
		$("#preview").html('');
	}

	$("#yaKonfirm").click(function() {
		var id = $("#pmx_id").val();
		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "hapus/" + id,
			success: function(d) {
				var res = JSON.parse(d);
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

	$('.tgl').daterangepicker({
		locale: {
			format: 'DD/MM/YYYY'
		},
		showDropdowns: true,
		singleDatePicker: true,
		"autoApply": true,
		opens: 'left'
	});

	$(document).ready(function() {
		drawTable();
	});
</script>