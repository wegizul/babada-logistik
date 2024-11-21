<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<span class="text-secondary" style="margin: 25px;"><i class="fas fa-home"></i> / Data Master / <b class="text-dark"><?= $page ?></b></span>
			<div class="card mt-3">
				<div class="card-header">
					<div class="row">
						<div class="col-md-10 pl-0">
							<i class="fas fa-cube mb-3"></i> <?= $page ?>
						</div>
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<a href="javascript:log_tambah()" class="btn btn-dark btn-block btn-sm"><i class="fa fa-user-plus"></i> &nbsp;&nbsp; Tambah User</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-pengguna" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th style="width: 5%;">No</th>
								<th>Nama</th>
								<th>Username</th>
								<th>Level</th>
								<th>Unit Kerja</th>
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

<div class="modal fade" id="modal_pengguna" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-user"></i> Form Pengguna</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg-6" name="Pengguna" id="frm_pengguna">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="log_id" name="log_id" value="">

						<div class="col-lg-12">
							<div class="form-group">
								<label>Nama</label>
								<input type="text" class="form-control" name="log_nama" id="log_nama" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Username</label>
								<input type="text" class="form-control" name="log_user" id="log_user" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Password</label>
								<input type="password" class="form-control" name="log_pass" id="log_pass" placeholder="Password" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Level</label>
								<select class="form-control" name="log_level" id="log_level">
									<option value="2">Admin Logistik</option>
									<option value="3">Admin Gudang</option>
									<option value="4">Konsumen</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Aktif</label>
								<select class="form-control" name="log_aktif" id="log_aktif">
									<option value="1">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Unit Kerja</label>
								<input type="text" class="form-control" name="log_unit_kerja" id="log_unit_kerja" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="log_simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
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

<!-- Custom Java Script -->
<script>
	var save_method; //for save method string
	var table;

	function drawTable() {
		$('#tabel-pengguna').DataTable({
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
				"url": "ajax_list_pengguna/",
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

	function log_tambah() {
		reset_form();
		$("#log_id").val(0);
		$("frm_pengguna").trigger("reset");
		$('#modal_pengguna').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_pengguna").submit(function(e) {
		e.preventDefault();
		$("#log_simpan").html("Menyimpan...");
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
					toastr.success(res.desc);
					drawTable();
					reset_form();
					$("#modal_pengguna").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#log_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#log_simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	$("#ok_info_ok").click(function() {
		$("#info_ok").modal("hide");
		drawTable();
	});

	$("#okKonfirm").click(function() {
		$(".utama").show();;
		$(".cadangan").hide();
		drawTable();
	});

	function hapus_pengguna(id) {
		event.preventDefault();
		$("#log_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_pengguna(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "cari",
			data: "log_id=" + id,
			dataType: "json",
			success: function(data) {
				$("#log_id").val(data.log_id);
				$("#log_nama").val(data.log_nama);
				$("#log_user").val(data.log_user);
				$("#log_level").val(data.log_level);
				$("#log_unit_kerja").val(data.log_unit_kerja);
				$(".inputan").attr("disabled", false);
				$("#modal_pengguna").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#log_id").val(0);
		$("#frm_pengguna")[0].reset();
	}

	$("#showPass").click(function() {
		var st = $(this).attr("st");
		if (st == 0) {
			$("#log_pass").attr("type", "text");
			$("#matanya").removeClass("fa-eye");
			$("#matanya").addClass("fa-eye-slash");
			$(this).attr("st", 1);
		} else {
			$("#log_pass").attr("type", "password");
			$("#matanya").removeClass("fa-eye-slash");
			$("#matanya").addClass("fa-eye");
			$(this).attr("st", 0);
		}
	});

	$("#yaKonfirm").click(function() {
		var id = $("#log_id").val();

		$("#isiKonfirm").html("Sedang menghapus data...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "GET",
			url: "hapus/" + id,
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

	$(document).ready(function() {
		drawTable();
	});
</script>