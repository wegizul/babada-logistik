<div class="inner">
	<span class="text-secondary" style="margin: 25px;"><i class="fas fa-home"></i> / <b class="text-dark"><?= $page ?></b></span>
	<div class="row">
		<?php foreach ($data as $d) { ?>
			<div class="col-md-3 col-sm-6 col-12 mt-3">
				<div class="card">
					<div class="card-header">
						<label class="text-dark"><?= $d->mtl_nama ?></label>
					</div>
					<div class="card-body text-center">
						<a onClick="detail(<?= $d->mtl_id ?>)" data-toggle="modal" type="button"><img src="<?= base_url('assets/files/material/' . $d->mtl_foto) ?>" width="100px"></a>
					</div>
					<div class="card-footer" style="background-color: #010536;">
						<label class="text-warning" style="float:left">Rp. <?= number_format($d->mtl_harga_jual, 0) ?></label>
						<input type="hidden" name="pjl_mtl_id" id="pjl_mtl_id" value="<?= $d->mtl_id ?>">
						<a id="simpan<?= $d->mtl_id ?>" onClick="tambahCart(<?= $d->mtl_id ?>)" class="text-warning" style="float:right" title="Tambah ke Keranjang"><i class="fas fa-cart-plus"></i></a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>

<div class="modal fade" id="detail" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-cube"></i> Detail Barang</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_detail">
				<input type="hidden" name="mtl_id" id="mtl_id" value="">
				<div class="modal-body form">
					<div class=" row">
						<div class="col-lg-4" id="preview">
						</div>
						<div class="col-lg-8">
							<h1 style="color: #010536;"><b id="mtl_nama"></b></h1>
							<h6 class="text-justify" id="mtl_deskripsi"></h6>
							<h2 class="text-warning"><b id="mtl_harga_jual"></b></h2>
							<div class="row">
								<div class="col-lg-2 mt-1"><label style="font-size: 20px;">Jumlah</label></div>
								<div class="col-lg-3"><input type="number" min="0" class="form-control" id="pjd_jumlah" name="pjd_jumlah"></div>
								<div class="col-lg-3 mt-1">Stok (<i id="mtl_stok"></i>)</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="det_simpan" class="btn btn-dark"><i class="fas fa-cart-plus"></i> Tambah</button>
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

	function tambahCart(id) {
		$("#simpan" + id).html("Menambahkan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "<?= base_url('Penjualan/simpan') ?>",
			data: "pjd_mtl_id=" + id,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#simpan" + id).html("<i class='fas fa-cart-plus'></i>");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#simpan" + id).html("Menambahkan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	}

	$("#frm_detail").submit(function(e) {
		e.preventDefault();
		$("#det_simpan").html("Menambahkan...");
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "<?= base_url('Penjualan/simpan2') ?>",
			data: new FormData(this),
			processData: false,
			contentType: false,
			success: function(d) {
				var res = JSON.parse(d);
				var msg = "";
				if (res.status == 1) {
					toastr.success(res.desc);
					$("#detail").modal("hide");
					reset_form();
				} else {
					toastr.error(res.desc);
				}
				$("#det_simpan").html("<i class='fas fa-cart-plus'></i> Tambah");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#det_simpan").html("Menambahkan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function detail(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "<?= base_url('Material/detail') ?>",
			data: "mtl_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					if (dt[0] == "mtl_foto") {
						$("#preview").append('<img src="<?= base_url('assets/files/material/') ?>' + dt[1] + '" width="200px">');
						$("#mtl_foto").html();
					} else if (dt[0] == "mtl_harga_jual") {
						$("#" + dt[0]).html("Rp. " + dt[1]);
					} else if (dt[0] == "mtl_id") {
						$("#" + dt[0]).val(dt[1]);
					} else {
						$("#" + dt[0]).html(dt[1]);
					}
				});
				$(".inputan").attr("disabled", false);
				$("#detail").modal({
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
		$("#frm_detail")[0].reset();
		$("#preview").html('');
	}

	$(document).ready(function() {});
</script>