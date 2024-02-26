<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-dark">
				<div class="card-header">
					<h3 class="card-title"><i class="fas fa-truck-fast fa-sm"></i> Scan Delivery</h3>
				</div>
				<div class="card-body form">
					<div class="row">
						<div class="col-lg-6">
							<label>Masukan Nomor Resi</label><br>
							<span id="error"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<input type="text" name="kode" id="kode" class="form-control" oninput="get_resi()" autofocus required>
						</div>
						<hr size="2" width="100%">
						<div class="col-lg-12">
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
					</div>
				</div>
				<div class="card-footer">
				</div>
			</div>
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

	function simpan(data) {
		$.ajax({
			type: "POST",
			url: "simpan",
			data: {
				bd_kode: data,
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
		if (!bd_kode) bd_kode = null;
		$.get("get_resi/" + bd_kode, {}, function(data) {
			if (data) {
				$('#error').html('');
				simpan(data);
			} else {
				$('#error').html('<small style="color: red;"><i>Nomor Resi Tidak Ditemukan</i></small>');
			}
		});
	}

	function reset_form() {
		$("#kode").val('');
	}

	$(document).ready(function() {
		drawTable();
	});
</script>