<div class="inner">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<a href="javascript:window.history.back()" class="btn btn-dark btn-sm"><i class="fa fa-reply"></i> &nbsp;Kembali</a>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
							</div>
						</div>
					</div>
					Pengajuan Klaim
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-klaim" width="100%" style="font-size:100%;">
						<thead>
							<tr>
								<th width="5%">No</th>
								<th>Tanggal Klaim</th>
								<th>Nomor Invoice</th>
								<th>Material</th>
								<th>Qty</th>
								<th>Keterangan</th>
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

<div class="modal fade" id="modal_klaim" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Konfirmasi klaim ini</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_klaim">
				<div class="modal-body form">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<textarea rows="3" class="form-control" name="rjt_keterangan" id="rjt_keterangan" disabled></textarea>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<input type="hidden" name="rjt_id" id="rjt_id" value="">
								<input type="hidden" name="rjt_pjl_id" id="rjt_pjl_id" value="">
								<input type="hidden" name="rjt_pjd_id" id="rjt_pjd_id" value="">
								<input type="hidden" name="rjt_material" id="rjt_material" value="">
								<input type="hidden" name="rjt_qty" id="rjt_qty" value="">
								<select class="form-control" name="pjd_status" id="pjd_status" onChange="aksi(this.value)">
									<option value="5">Konfirmasi Klaim</option>
									<option value="3">Tolak Klaim</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12" id="tindakan">
							<div class="form-group">
								<label>Pilih Tindakan</label>
								<select class="form-control" id="rjt_tindakan" name="rjt_tindakan" style="font-size: 14px;">
									<option value="Tukar">Tukar Barang (kembalikan barang yang diklaim, kirim barang baru)</option>
									<option value="Ganti">Ganti Barang (kirim barang baru tanpa mengembalikan barang yang diklaim)</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12" id="catatan" style="display: none;">
							<div class="form-group">
								<label>Alasan Penolakan</label>
								<textarea rows="3" class="form-control" name="rjt_catatan" id="rjt_catatan" placeholder="Tulis alasan penolakan klaim"></textarea>
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

<!-- Sweet alert -->
<script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<script>
	var save_method;
	var table;
	var pjl_id = $("#pjl_id").val();
	$('#rjt_pjl_id').val(pjl_id);

	function drawTable() {
		$('#tabel-klaim').DataTable({
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
				"url": "ajax_list_klaim/",
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

	function hapus_klaim(id) {
		event.preventDefault();
		$("#rjt_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function reset_form() {
		$("#rjt_id").val(0);
		$("#frm_klaim")[0].reset();
	}

	$("#yaKonfirm").click(function() {
		var id = $("#rjt_id").val();
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
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	});

	function getKlaim(rjt) {
		event.preventDefault();
		$.ajax({
			type: "GET",
			url: "get_klaim/" + rjt,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				return false;
			}
		});
	}

	function konfirmasi(id) {
		getKlaim(id);
		$("#rjt_id").val(id);
		$("frm_klaim").trigger("reset");
		$('#modal_klaim').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_klaim").submit(function(e) {
		e.preventDefault();
		$("#simpan").html("Menyimpan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "konfirm_klaim",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				if (res.status == 1) {
					toastr.success(res.desc);
					drawTable();
					$("#modal_klaim").modal("hide");
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

	function aksi(pil) {
		if (pil == 5) {
			$('#tindakan').show();
			$('#catatan').hide();
		} else {
			$('#tindakan').hide();
			$('#catatan').show();
		}
	}

	$(document).ready(function() {
		drawTable();
	});
</script>