<?php
$bulan = [
	'1' => 'Januari',
	'2' => 'Februari',
	'3' => 'Maret',
	'4' => 'April',
	'5' => 'Mei',
	'6' => 'Juni',
	'7' => 'Juli',
	'8' => 'Agustus',
	'9' => 'September',
	'10' => 'Oktober',
	'11' => 'November',
	'12' => 'Desember',
]
?>
<div class="inner">
	<div class="row">
		<input type="hidden" name="pbl_id" id="pbl_id">
		<div class="col-lg-12">
			<span class="text-secondary" style="margin: 25px;"><i class="fas fa-home"></i> / <b class="text-dark"><?= $page ?></b></span>
			<div class="card mt-3">
				<div class="card-header">
					<div class="row">
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<select class="form-control form-control-sm" name="filter" id="filter" onChange="drawTable()">
									<option value="">Pilih Bulan</option>
									<?php foreach ($bulan as $key => $val) { ?>
										<option value="<?= $key ?>"><?= $val ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-2 col-xs-12">
							<div class="form-group">
								<button class="btn btn-sm btn-dark" onClick="ekspor()"><i class="fas fa-file-excel"></i> Export to Excel</button>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<a href="<?= base_url('Pembelian/tampil') ?>" class="btn btn-dark btn-block btn-sm"><i class="fa fa-plus-circle"></i> &nbsp; Tambah Pembelian</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-data" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Tanggal</th>
								<th>Faktur</th>
								<th>Supplier</th>
								<th>Total Item</th>
								<th>Jumlah</th>
								<th>OB</th>
								<th>PPn</th>
								<th>Total</th>
								<?php if ($this->session->userdata('level') == 1) { ?>
									<th>Aksi</th>
								<?php } ?>
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

<div class="modal fade" id="modal_rincian" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-clipboard-list"></i> Rincian Pembelian</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-8">
						<h1 id="pbd_id"></h1>
					</div>
					<div class="col-lg-4">
						<img src="<?= base_url('assets/files/logo.png') ?>" width="50px" style="float: right;">
					</div>
				</div>
			</div>
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

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<script>
	var save_method;
	var table;

	function drawTable() {
		var bulan = $('#filter').val();
		if (!bulan) bulan = null;
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
			"order": [],
			"ajax": {
				"url": "ajax_list_pembelian/" + bulan,
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

	function hapus_pembelian(id) {
		event.preventDefault();
		$("#pbl_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function reset_form() {
		$("#pbl_id").val(0);
		$("#frm_pembelian")[0].reset();
	}

	$("#yaKonfirm").click(function() {
		var id = $("#pbl_id").val();
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
			format: 'YYYY-MM-DD'
		},
		showDropdowns: true,
		singleDatePicker: true,
		"autoApply": true,
		opens: 'left'
	});

	function ekspor() {
		var bln = $('#filter').val();
		if (!bln) bln = null;
		window.open("<?= base_url('Pembelian/export/') ?>" + bln);
	}

	$(document).ready(function() {
		drawTable();
	});
</script>