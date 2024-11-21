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
						<div class="col-md-9 pl-0">
							<div class="form-group">
								<a href="javascript:tambah_saldo()" class="btn btn-dark btn-sm"><i class="fa fa-plus-circle"></i> &nbsp; Tambah Saldo</a>
								<?php if ($cek_saldo) { ?>
									<a href="javascript:tambah()" class="btn btn-dark btn-sm mr-3"><i class="fa fa-plus-circle"></i> &nbsp; Tambah Pengeluaran</a>
								<?php } else { ?>
									<button onClick="tambah()" id="btnKel" class="btn btn-dark btn-sm mr-3" disabled><i class="fa fa-plus-circle"></i> &nbsp; Tambah Pengeluaran</button> <small class="text-red"><b>*Tambahkan Saldo terlebih dahulu</b></small>
								<?php } ?>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<select class="form-control form-control-sm" name="filter" id="filter" onChange="drawTable()">
											<option value="">Pilih Bulan</option>
											<?php foreach ($bulan as $key => $val) { ?>
												<option value="<?= $key ?>"><?= $val ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<select class="form-control form-control-sm" name="filter_tipe" id="filter_tipe" onChange="drawTable()">
											<option value="">Pilih Tipe</option>
											<option value="ATK">ATK</option>
											<option value="BBM dan Parkir">BBM dan Parkir</option>
											<option value="Biaya Perjalanan Dinas">Biaya Perjalanan Dinas</option>
											<option value="Kebersihan">Kebersihan</option>
											<option value="Listik dan Wifi">Listik dan Wifi</option>
											<option value="Operasional Lain">Operasional Lain</option>
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
						<div class="col-md-3 pl-0" id="topeng">
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
								<th>Tipe</th>
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
						<div class="col-lg-6 mb-3">
							<label>Tanggal</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control" name="kel_tanggal" id="kel_tanggal" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-6">
							<label>Tipe</label>
							<div class="form-group">
								<select class="form-control" id="kel_tipe" name="kel_tipe">
									<option value="">Pilih</option>
									<option value="ATK">ATK</option>
									<option value="BBM dan Parkir">BBM dan Parkir</option>
									<option value="Biaya Perjalanan Dinas">Biaya Perjalanan Dinas</option>
									<option value="Kebersihan">Kebersihan</option>
									<option value="Listik dan Wifi">Listik dan Wifi</option>
									<option value="Operasional Lain">Operasional Lain</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<label>Nama Pengeluaran</label>
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

<div class="modal fade" id="modal_saldo" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cube"></i> Tambah Dana Operasional</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_saldo">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="dop_id" name="dop_id" value="">
						<input type="hidden" id="dop_terpakai" name="dop_terpakai" value="0">
						<input type="hidden" id="dop_user_input" name="dop_user_input" value="<?= $this->session->userdata('id_user') ?>">
						<div class="col-lg-12 mb-3">
							<label>Tanggal</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control" name="dop_tanggal" id="dop_tanggal" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-12 mb-3">
							<label>Jumlah Dana</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp </span>
								</div>
								<input type="number" min="0" class="form-control" name="dop_jumlah" id="dop_jumlah" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="dop_simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
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
		var bulan = $('#filter').val();
		if (!bulan) bulan = <?= date('n') ?>;
		var tipe = $('#filter_tipe').val();
		if (!tipe) tipe = null;

		$('#topeng').load("<?= base_url('Pengeluaran/total_pengeluaran/') ?>" + bulan);

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
				"url": "ajax_list_pengeluaran/" + bulan + "/" + tipe,
				"type": "POST"
			},
			"columnDefs": [{
				"targets": [-1],
				"orderable": false,
			}, ],
			"initComplete": function(settings, json) {
				$("#process").html("Process...")
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
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#modal_pengeluaran").modal("hide");
					drawTable();
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#kel_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#kel_simpan").html("Error");
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
		$("#dop_id").val(0);
		$("#frm_saldo")[0].reset();
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
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#frmKonfirm").modal("hide");
					drawTable();
				} else {
					toastr.error(res.desc);
				}
				$(".btn").attr("disabled", false);
				$(".btnKel").attr("disabled", true);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	});

	function tambah_saldo() {
		$("#dop_id").val(0);
		$("frm_saldo").trigger("reset");
		$('#modal_saldo').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_saldo").submit(function(e) {
		e.preventDefault();
		$("#dop_simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "simpan_saldo",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#modal_saldo").modal("hide");
					window.location.reload();
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#dop_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#dop_simpan").html("Error");
				$(".btn").attr("disabled", false);
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