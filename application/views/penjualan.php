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
						<div class="col-md-2">
							<div class="form-group">
								<select class="form-control form-control-sm" name="filter" id="filter" onChange="drawTable()">
									<option value="">Filter Bulan</option>
									<?php foreach ($bulan as $key => $val) { ?>
										<option value="<?= $key ?>"><?= $val ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-8 col-xs-12">
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<a href="javascript:add_penjualan()" class="btn btn-dark btn-block btn-sm"><i class="fa fa-plus-circle"></i> &nbsp; Tambah Penjualan</a>
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
	<div class="modal-dialog modal-lg">
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
								<select class="form-control form-control-sm select2" name="pjl_customer" id="pjl_customer" style="width:100%;line-height:100px;" required>
									<option value="">Pilih Customer</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<label>Tanggal</label> <span class="text-danger">*</span>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control form-control-sm" name="pjl_tanggal" id="pjl_tanggal" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Jenis Harga</label>
								<select class="form-control form-control-sm" name="pjl_jenis_harga" id="pjl_jenis_harga">
									<option value="1">Mark Up 4%</option>
									<option value="2">HPP</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Tipe Pembayaran</label>
								<select class="form-control form-control-sm" name="pjl_jenis_bayar" id="pjl_jenis_bayar">
									<option value="1">Transfer</option>
									<option value="2">Cash</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Status Pembayaran</label>
								<select class="form-control form-control-sm" name="pjl_status_bayar" id="pjl_status_bayar">
									<option value="0">Tertunda</option>
									<option value="1">Jatuh Tempo</option>
									<option value="2">Lunas</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Status Penjualan</label>
								<select class="form-control form-control-sm" name="pjl_status" id="pjl_status">
									<option value="2">Dikirim</option>
									<option value="1">Menunggu Konfirmasi</option>
									<option value="3">Ditolak</option>
									<option value="4">Selesai</option>
								</select>
							</div>
						</div>
						<div class="col-lg-4" style="margin-top: 20px;">
							<h5><b>Detail Barang</b></h5>
						</div>
						<div class="col-lg-8" style="margin-top: 20px;">
							<select class="form-control select2" style="width: 100%;" onChange="cari_material(this.value)" autofocus>
								<option value="">Pilih Item</option>
								<?php foreach ($material as $m) { ?>
									<option value="<?= $m->mtl_id ?>"><?= $m->mtl_nama ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-lg-12" style="margin-top: 20px;">
							<div class="form-group">
								<table class="table">
									<tr>
										<th width="45%">Item <span class="text-danger">*</span></th>
										<th width="30%">Qty <span class="text-danger">*</span></th>
										<th width="20%">Satuan <span class="text-danger">*</span></th>
										<!-- <th width="20%">Harga <span class="text-danger">*</span></th> -->
										<th></th>
									</tr>
								</table>
								<table class="table">
									<tr id="list_item"></tr>
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
								<input type="hidden" name="pjl_id2" id="pjl_id2" value="">
								<select class="form-control" name="pjl_status2" id="pjl_status2">
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

<div class="modal fade" id="modal_pembayaran" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-hand-holding-usd"></i> Tambah Pembayaran</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_pembayaran">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" name="pjl_id3" id="pjl_id3" value="">
						<div class="col-lg-6">
							<label>Tanggal</label> <span class="text-danger">*</span>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
								</div>
								<input type="date" class="form-control form-control-sm" name="pjl_tanggal3" id="pjl_tanggal3" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Tipe Pembayaran</label>
								<select class="form-control form-control-sm" name="pjl_jenis_bayar3" id="pjl_jenis_bayar3">
									<option value="1">Transfer</option>
									<option value="2">Cash</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Status Pembayaran</label>
								<select class="form-control form-control-sm" name="pjl_status_bayar3" id="pjl_status_bayar3">
									<option value="2">Lunas</option>
									<option value="0">Tertunda</option>
									<option value="1">Jatuh Tempo</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Status Penjualan</label>
								<select class="form-control form-control-sm" name="pjl_status3" id="pjl_status3">
									<option value="4">Selesai</option>
									<option value="2">Dikirim</option>
									<option value="1">Menunggu Konfirmasi</option>
									<option value="3">Ditolak</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="simpan_pembayaran" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
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
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					$("#modal_konfirm").modal("hide");
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function pembayaran(id) {
		$("#pjl_id3").val(id);
		$("frm_pembayaran").trigger("reset");
		$('#modal_pembayaran').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_pembayaran").submit(function(e) {
		e.preventDefault();
		$("#simpan_pembayaran").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "pembayaran",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					$("#modal_pembayaran").modal("hide");
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	document.addEventListener('DOMContentLoaded', function() {
		// Mengambil data dari API menggunakan fetch
		fetch('https://dreampos.id/admin/Api/getWarehouses')
			.then(response => response.json())
			.then(data => {
				// Memproses data yang diterima
				var select = document.getElementById('pjl_customer');
				data.forEach(product => {
					var opt = document.createElement('option');
					opt.value = product.name;
					opt.innerHTML = product.name;
					select.appendChild(opt);
				});
			})
			.catch(error => {
				console.error('Error fetching data:', error);
			});
	});

	function add_penjualan() {
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
				if (res.status == 1) {
					Swal.fire(
						'Sukses',
						res.desc,
						'success'
					).then((result) => {
						if (!result.isConfirmed) {
							$("#modal_penjualan").modal("hide");
							window.open("<?= base_url('Penjualan/cetak_resi/') ?>", "_blank");
							drawTable();
							reset_form();
						} else {}
					})
				} else {
					toastr.error(res.desc);
				}
				$("#pjl_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#pjl_simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	$('.select2').select2({
		className: "form-control"
	});

	function cari_material(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "cari_material",
			data: "mtl_id=" + id,
			dataType: "json",
			success: function(data) {
				tambah(data);
				return false;
			}
		});
	}

	var i = 1;

	function tambah(val) {
		i++;
		$('#list_item').append('<tr id="row' + i + '">' +
			`<td width="45%">
				` + val.mtl_nama + `
				<input type="hidden" id="pjd_mtl_id` + i + `" name="pjd_mtl_id[]" value="` + val.mtl_id + `" class="form-control form-control-sm" readonly>
			</td>
			<td width="30%">
				<input type="number" min="0" id="pjd_qty` + i + `" name="pjd_qty[]" class="form-control form-control-sm" required>
			</td>
			<td width="20%">
				` + val.smt_nama + `
				<input type="hidden" id="pjd_smt_id` + i + `" name="pjd_smt_id[]" value="` + val.smt_id + `" class="form-control form-control-sm">
			</td>
			<td>
			<span name="hapus" id="` + i + `" class="hapus"><i class="fas fa-trash-alt"></i></span></td>` +
			'</tr>'
		);
	}

	$(document).on('click', '.hapus', function() {
		i--;
		var btn_hapus = $(this).attr("id");
		$('#row' + btn_hapus + '').remove();
	});

	function reset_form() {
		$("#frm_konfirm")[0].reset();
		$("#frm_penjualan")[0].reset();
		$("#frm_pembayaran")[0].reset();
	}

	$(document).ready(function() {
		drawTable();
	});
</script>