<div class="inner">
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<span class="text-secondary" style="margin: 25px;"><i class="fas fa-home"></i> / <b class="text-dark"><?= $page ?></b></span>
			<div class="card mt-3">
				<div class="card-header">
					<div class="row">
						<div class="col-md-9 pl-0">
							<div class="form-group">
								<a href="javascript:tambah()" class="btn btn-dark btn-sm"><i class="fa fa-plus-circle"></i> &nbsp; Tambah Pengeluaran</a>
							</div>
						</div>
						<div class="col-md-3 pl-0">
							<h6 style="margin-bottom: 0px;"><b>Total Pengeluaran</b></h6>
							<h1 style="font-weight: bolder;">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></h1>
						</div>
					</div>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-data" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th style="width:5%;">No</th>
								<th>Tanggal</th>
								<th>Pengeluaran</th>
								<th>Jumlah</th>
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

<div class="modal fade" id="modal_pengeluaran" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cube"></i> Form Pengeluaran</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_pengeluaran">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="kel_id" name="kel_id" value="">
						<div class="col-lg-12 mb-3">
							<label>Tanggal</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control" name="kel_tanggal" id="kel_tanggal" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-12">
							<label>Pengeluaran</label>
							<div class="form-group">
								<input type="text" class="form-control" name="kel_nama" id="kel_nama" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-12 mb-3">
							<label>Jumlah</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp </span>
								</div>
								<input type="number" min="0" class="form-control" name="kel_jml" id="kel_jml" required>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Keterangan</label>
								<textarea rows="3" class="form-control" name="kel_ket" id="kel_ket"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="kel_simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
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
<script src="<?= base_url("assets"); ?>/plugins/select2/select2.js"></script>

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
				"url": "ajax_list_pengeluaran/",
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
		$("#kel_id").val(0);
		$("frm_pengeluaran").trigger("reset");
		$('#modal_pengeluaran').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_pengeluaran").submit(function(e) {
		e.preventDefault();
		$("#kel_simpan").html("Menyimpan...");
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
					$("#modal_pengeluaran").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#kel_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function hapus_pengeluaran(id) {
		event.preventDefault();
		$("#kel_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_pengeluaran(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "cari",
			data: "kel_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_pengeluaran").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#kel_id").val(0);
		$("#frm_pengeluaran")[0].reset();
	}

	$("#yaKonfirm").click(function() {
		var id = $("#kel_id").val();
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

	$(document).ready(function() {
		drawTable();
	});
</script>