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
		<div class="col-lg-12">
			<span class="text-secondary" style="margin: 25px;"><i class="fas fa-home"></i> / <b class="text-dark"><?= $page ?></b></span>
			<div class="card mt-3">
				<div class="card-header">
					<div class="row">
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<select class="form-control form-control-sm" name="filter" id="filter" onChange="drawTable()">
									<option value="">Filter Bulan</option>
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
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<select class="form-control form-control-sm select2" name="filter_cus" id="filter_cus" style="width:100%;line-height:100px;" onChange="drawTable()">
									<option value="">Filter Customer</option>
								</select>
							</div>
						</div>
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<select class="form-control form-control-sm select2" name="filter_mtl" id="filter_mtl" onChange="drawTable()">
									<option value="">Filter Material</option>
									<?php foreach ($material as $m) { ?>
										<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
									<?php } ?>
								</select>
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
								<th>Jenis</th>
								<th>Nama Material</th>
								<th>Total Penjualan</th>
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
		var bulan = $('#filter').val();
		if (!bulan) bulan = 0;
		var tgl = $('#filter_tgl').val();
		if (!tgl) tgl = 0;
		var cus = $('#filter_cus').val();
		if (!cus) cus = 0;
		var mtl = $('#filter_mtl').val();
		if (!mtl) mtl = 0;

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
				"url": "ajax_list_laporan/" + cus + "/" + mtl + "/" + bulan + "/" + tgl,
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [-2, -3],
				"orderable": false,
			}, ],
			"initComplete": function(settings, json) {
				$("#process").html("Process...")
				$(".btn").attr("disabled", false);
				$("#isidata").fadeIn();
			}
		});
	}

	document.addEventListener('DOMContentLoaded', function() {
		// Mengambil data dari API menggunakan fetch
		fetch('https://dreampos.id/admin/Api/getCustomer')
			.then(response => response.json())
			.then(data => {
				// Memproses data yang diterima
				var select = document.getElementById('filter_cus');
				data.forEach(customer => {
					var opt = document.createElement('option');
					opt.value = customer.id;
					opt.innerHTML = customer.name;
					select.appendChild(opt);
				});
			})
			.catch(error => {
				console.error('Error fetching data:', error);
			});
	});

	function ekspor() {
		var bln = $('#filter').val();
		if (!bln) bln = null;
		window.open("<?= base_url('Material/export/') ?>" + bln);
	}

	$('.select2').select2({
		className: "form-control"
	});

	$(document).ready(function() {
		drawTable();
	});
</script>