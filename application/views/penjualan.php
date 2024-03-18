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
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<span class="text-secondary" style="margin: 25px;"><i class="fas fa-home"></i> / <b class="text-dark"><?= $page ?></b></span>
			<div class="card mt-3">
				<div class="card-header">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<select class="form-control form-control-sm" name="bulan" id="bulan">
									<option value="">Pilih Bulan</option>
									<?php foreach ($bulan as $key => $val) { ?>
										<option value="<?= $key ?>"><?= $val ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-8 col-xs-12">
							<div class="form-group">
								<button class="btn btn-sm btn-dark" onClick="ekspor()"><i class="fas fa-file-excel"></i> &nbsp; Export to Excel</button>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<a href="javascript:tambah()" class="btn btn-dark btn-block btn-sm"><i class="fa fa-plus-circle"></i> &nbsp; Tambah Penjualan</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-data" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal Pesanan</th>
								<th>Nama Pemesan</th>
								<th>Total Item</th>
								<th>Jumlah Bayar</th>
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

<div class="modal fade" id="modal_penjualan" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cart-plus"></i> Form Penjualan</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="Penjualan" id="frm_penjualan">
				<div class="card-body form">
					<div class="row">
						<input type="hidden" id="pjl_id" name="pjl_id" value="">
						<div class="col-lg-4">
							<div class="form-group">
								<label>Customer</label> <span class="text-danger">*</span>
								<select class="form-control select2" name="pjl_customer" id="pjl_customer" style="width:100%;line-height:100px;" required>
									<option value="">Pilih Customer</option>
									<?php foreach ($customer as $s) { ?>
										<option value="<?= $s->name ?>"><?= strtoupper($s->name) ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<label>Tanggal</label> <span class="text-danger">*</span>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control" name="pjl_tanggal" id="pjl_tanggal" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-4">
							<label>Total Harga</label> <span class="text-danger">*</span>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">Rp</span>
								</div>
								<input type="number" min="0" class="form-control" name="pbl_total_harga" id="pbl_total_harga" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Jenis Harga</label>
								<select class="form-control" name="pjl_jenis_harga" id="pjl_jenis_harga">
									<option value="1">Mark Up 4%</option>
									<option value="2">HPP</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Tipe Pembayaran</label>
								<select class="form-control" name="pjl_jenis_bayar" id="pjl_jenis_bayar">
									<option value="1">Transfer</option>
									<option value="2">Cash</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Status Pembayaran</label>
								<select class="form-control" name="pjl_status_bayar" id="pjl_status_bayar">
									<option value="0">Tertunda</option>
									<option value="1">Jatuh Tempo</option>
									<option value="2">Lunas</option>
								</select>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Status Penjualan</label>
								<select class="form-control" name="pjl_status" id="pjl_status">
									<option value="1">Menunggu Konfirmasi</option>
									<option value="2">Dikirim</option>
									<option value="3">Ditolak</option>
									<option value="4">Selesai</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12" style="margin-top: 20px;">
							<h5><b>Detail Barang</b></h5>
							<div class="form-group">
								<table class="table">
									<tr id="dynamic_field"></tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="col-lg-12" style="float:right;">
						<button type="submit" id="pjl_simpan" class="btn btn-dark" style="float: right;"><i class="fas fa-paper-plane"></i> Kirim</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_konfirm" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Konfirmasi penjualan ini</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_konfirm">
				<div class="modal-body form">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<input type="hidden" name="pjl_id" id="pjl_id2" value="">
								<select class="form-control" name="pjl_status" id="pjl_status2">
									<option value="2">Konfirmasi Penjualan</option>
									<option value="3">Tolak Penjualan</option>
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

<!-- Sweet alert -->
<script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<script>
	var save_method;
	var table;

	function drawTable() {
		var bulan = $('#bulan').val();
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
				"url": "ajax_list_penjualan/" + bulan,
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

	function konfirmasi(id) {
		$("#pjl_id2").val(id);
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
			url: "konfirmasi",
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
					$("#modal_konfirm").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function tambah() {
		nilai();
		$("#pjl_id").val(0);
		$("frm_penjualan").trigger("reset");
		$('#modal_penjualan').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_penjualan").submit(function(e) {
		e.preventDefault();
		$("#pjl_simpan").html("Menyimpan...");
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
				$("#pjl_simpan").html("<i class='fas fa-paper-plane'></i> Kirim");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#pjl_simpan").html("<i class='fas fa-paper-plane'></i> Kirim");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	$('.select2').select2({
		className: "form-control"
	});

	var i = 1;

	function tambah_item() {
		i++;
		$('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added">' +
			`<td><select id="pbd_mtl_id` + i + `" name="pbd_mtl_id[]" class="form-control">
					<option value="">Pilih Item</option>
					<?php foreach ($material as $m) { ?>
						<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
					<?php } ?>
				</select>
			</td>
			<td>
				<input type="number" min="0" id="pbd_qty` + i + `" name="pbd_qty[]" class="form-control">
			</td>
			<td><select id="pbd_smt_id` + i + `" name="pbd_smt_id[]" class="form-control">
					<option value="">Pilih Satuan</option>
					<?php foreach ($satuan_material as $sm) { ?>
						<option value="<?= $sm->smt_id ?>"><?= $sm->smt_nama ?></option>
					<?php } ?>
				</select>
			</td>
			<td class="input-group input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Rp</span>
				</div>
				<input type="number" min="0" id="pbd_harga` + i + `" name="pbd_harga[]" class="form-control">
			</td>
			<td>
			<button type="button" name="remove" id="` + i + `" class="btn btn-danger btn_remove btn-xs"><i class="fas fa-minus-circle"></i></button></td>` +
			'</tr>'
		);
	}

	$(document).on('click', '.btn_remove', function() {
		i--;
		var button_id = $(this).attr("id");
		$('#row' + button_id + '').remove();
	});

	function nilai() {
		$("#dynamic_field").html(`<tr>
			<th width="35%">Item <span class="text-danger">*</span></th>
			<th width="15%">Qty <span class="text-danger">*</span></th>
			<th width="15%">Satuan <span class="text-danger">*</span></th>
			<th width="25%">Harga <span class="text-danger">*</span></th>
			<td width="10%"><button type="button" name="add" id="add" onclick="tambah_item()" class="btn btn-dark btn-xs"><i class="fas fa-plus-circle"></i></button></td>
		</tr>
		<tr>
			<td><select id="pbd_mtl_id" name="pbd_mtl_id[]" class="form-control">
					<option value="">Pilih Item</option>
					<?php foreach ($material as $m) { ?>
						<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
					<?php } ?>
				</select>
			</td>
			<td>
				<input type="number" min="0" id="pbd_qty" name="pbd_qty[]" class="form-control">
			</td>
			<td><select id="pbd_smt_id" name="pbd_smt_id[]" class="form-control">
					<option value="">Pilih Satuan</option>
					<?php foreach ($satuan_material as $sm) { ?>
						<option value="<?= $sm->smt_id ?>"><?= $sm->smt_nama ?></option>
					<?php } ?>
				</select>
			</td>
			<td class="input-group input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text">Rp</span>
				</div>
				<input type="number" min="0" id="pbd_harga" name="pbd_harga[]" class="form-control">
			</td>	
		</tr>`);
	}

	function reset_form() {
		$("#frm_konfirm")[0].reset();
		// nilai();
	}

	$(document).ready(function() {
		drawTable();
		// nilai();
	});
</script>