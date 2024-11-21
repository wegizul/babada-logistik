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
		<input type="hidden" name="pjl_id" id="pjl_id">
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
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<input type="date" class="form-control form-control-sm" name="filter_tgl" id="filter_tgl" onChange="drawTable()">
							</div>
						</div>
						<div class="col-md-2 col-xs-12">
							<div class="form-group">
								<button class="btn btn-sm btn-dark" onClick="ekspor()"><i class="fas fa-file-excel"></i> Export to Excel</button>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-data" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th style="width: 5%;">No</th>
								<th>Tanggal</th>
								<th>Invoice</th>
								<th>Customer</th>
								<th>Total Item</th>
								<th>Jumlah Bayar</th>
								<th>Pembayaran</th>
								<th>Status</th>
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

<div class="modal fade" id="modal_detail" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-list"></i> Detail Pesanan</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close">&times;</span>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<th>Nama Barang</th>
						<th>Qty</th>
						<th>Satuan</th>
					</thead>
					<tbody id="isi" style="font-size:small;">
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button aria-hidden="true" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i> Tutup</button>
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
<!-- Select 2 -->
<script src="<?= base_url("assets"); ?>/plugins/select2/select2.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<script>
	var save_method;
	var table;

	function drawTable() {
		var bulan = $('#filter').val();
		var tgl = $('#filter_tgl').val();
		if (!bulan) bulan = null;
		if (!tgl) tgl = null;
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
				"url": "ajax_list_penjualan/" + bulan + "/" + tgl,
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

	function ekspor() {
		var bln = $('#filter').val();
		if (!bln) bln = null;
		var tgl = $('#filter_tgl').val();
		if (!tgl) tgl = null;
		window.open("<?= base_url('LapPenjualan/export/') ?>" + bln + "/" + tgl);
	}

	function detail(id) {
		$('#isi').html('')
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "<?= base_url('Dashboard/detail_pesanan/') ?>" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.forEach((dt) => {
					$("#isi").append(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_detail").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	$(document).ready(function() {
		drawTable();
	});
</script>