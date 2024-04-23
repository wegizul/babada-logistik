<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<span class="text-secondary" style="margin: 25px;"><i class="fas fa-home"></i> / <b class="text-dark"><?= $page ?></b></span>
			<div class="card mt-3">
				<div class="card-header">
					<div class="row">
						<div class="col-md-10 pl-0">
							<i class="fas fa-cube mb-3"></i> <?= $page ?>
						</div>
						<div class="col-md-2 pl-0">
							<div class="form-group">
								<a href="javascript:tambah()" class="btn btn-dark btn-block btn-sm"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp; Produk Baru</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-data" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th style="width: 5%;">No</th>
								<th>Gambar</th>
								<th>Nama Material</th>
								<th>Stok</th>
								<th>Harga Modal</th>
								<th>Harga Jual</th>
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

<div class="modal fade" id="modal_material" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cube"></i> Form Material</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_material">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="mtl_id" name="mtl_id" value="">
						<div class="col-lg-5">
							<div class="form-group">
								<label>Nama Material</label>
								<input type="text" class="form-control" name="mtl_nama" id="mtl_nama" autocomplete="off" required>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Kode Produk</label>
								<input type="number" min="0" class="form-control" name="mtl_kode" id="mtl_kode" required>
							</div>
						</div>
						<?php if ($this->session->userdata('level') == 1) { ?>
							<div class="col-lg-2">
								<div class="form-group">
									<label>Jumlah Stok</label>
									<input type="number" min="0" class="form-control" name="mtl_stok" id="mtl_stok">
								</div>
							</div>
						<?php } ?>
						<div class="col-lg-2">
							<div class="form-group">
								<label>Satuan</label>
								<select class="form-control" name="mtl_satuan" id="mtl_satuan" required>
									<option value="">Pilih</option>
									<?php foreach ($satuan as $s) { ?>
										<option value="<?= $s->smt_id ?>"><?= $s->smt_nama ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Deskripsi</label>
								<textarea rows="4" class="form-control" name="mtl_deskripsi" id="mtl_deskripsi"></textarea>
							</div>
						</div>
						<div class="input-group input-group col-lg-6 mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Rp. </span>
							</div>
							<input type="text" class="form-control" name="mtl_harga_modal" id="mtl_harga_modal" placeholder="Harga Modal" required>
						</div>
						<div class="input-group input-group col-lg-6 mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Rp. </span>
							</div>
							<input type="text" class="form-control" name="mtl_harga_jual" id="mtl_harga_jual" placeholder="Harga Jual" required>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Foto Material</label><small><i> (ukuran foto 1080 x 1080 pixel)</i></small>
								<div id="preview"></div>
								<input type="file" accept=".jpg, .jpeg, .png" class="form-control" name="mtl_foto" id="mtl_foto">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="mtl_simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
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
				"url": "ajax_list_material/",
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
		$("#mtl_id").val(0);
		$("frm_material").trigger("reset");
		$('#modal_material').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_material").submit(function(e) {
		e.preventDefault();
		$("#mtl_simpan").html("Menyimpan...");
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
					$("#modal_material").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#mtl_simpan").html("<i class='fas fa-check-circle'></i> Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#mtl_simpan").html("Error");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function hapus_material(id) {
		event.preventDefault();
		$("#mtl_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_material(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "cari",
			data: "mtl_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == "mtl_foto") {
						$("#preview").append('<img src="<?= base_url('assets/files/material/') ?>' + dt[1] + '" width="100px">');
						$("#mtl_foto").val();
					} else {
						$("#" + dt[0]).val(dt[1]);
					}
				});
				$(".inputan").attr("disabled", false);
				$("#modal_material").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#mtl_id").val(0);
		$("#frm_material")[0].reset();
		$("#preview").html('');
	}

	$("#yaKonfirm").click(function() {
		var id = $("#mtl_id").val();
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