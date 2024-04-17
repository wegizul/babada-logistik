<style>
	.filterr {
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 50%;
	}
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<div class="inner">
	<div class="row">
		<div class="col-lg-8">
			<div class="card" style="padding:15px 15px 15px 15px;">
				<h6 style="font-weight:bold"><i class="fas fa-chart-line"></i> Total Penjualan perbulan</h6>
				<select id="filter_tahun" class="form-control filterr" onChange="filter_tahun()">
					<option value="0">Pilih Tahun</option>
					<?php
					for ($thn = date('Y'); $thn > (date('Y') - 3); $thn--) {
					?>
						<option value="<?= $thn ?>"><?= $thn; ?></option>
					<?php
					} ?>
				</select>
				<div id="chartpenjualancontainer">
					<canvas id="chartpenjualan" height="300px"></canvas>
				</div>
				<script>
					var thn = 0;

					function reset_grafik_penjualan() {
						$('#chartpenjualan').remove(); // this is my <canvas> element
						$('#chartpenjualancontainer').append('<canvas id="chartpenjualan" height="300px"><canvas>');
					}

					function tampil_grafik_penjualan() {
						$.get("<?= base_url(); ?>Dashboard/grafik_penjualan/" + thn, {}, function(penjualan) {
							var pjl = JSON.parse(penjualan);
							var bar = document.getElementById("chartpenjualan").getContext('2d');
							var myChart = new Chart(bar, {
								type: 'bar',
								data: {
									labels: pjl.label,
									datasets: pjl.dataset
								},
								options: {
									maintainAspectRatio: false,
									scales: {
										yAxes: [{
											ticks: {
												beginAtZero: true
											}
										}],
										xAxes: [{
											ticks: {
												// Include a dollar sign in the ticks
												labelString: pjl.dataset.label
											}
										}]
									},
									tooltips: {
										callbacks: {
											label: function(tooltipItem, data) {
												return Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
													return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
												}) + " Transaksi";
											}
										}
									}
								}
							});
						});
					}

					function filter_tahun() {
						event.preventDefault();
						reset_grafik_penjualan();
						thn = $("#filter_tahun").val();

						tampil_grafik_penjualan();
					}
					tampil_grafik_penjualan();
				</script>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card" style="height: 395px;">
				<div class="card-header">
					<h6 style="font-weight:bold"><i class="fas fa-cart-plus"></i> Pesanan Baru</h6>
				</div>
				<div class="card-body" style="overflow-y: scroll; height: 420px">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<th>Tanggal</th>
							<th>Konsumen</th>
							<th>Aksi</th>
						</thead>
						<tbody style="font-size:small;">
							<?php if ($pesanan) foreach ($pesanan as $odr) { ?>
								<tr>
									<td><?= $odr->pjl_tanggal ?></td>
									<td onClick="detail(<?= $odr->pjl_id ?>)" style="cursor:pointer;"><?= $odr->pjl_customer ?></td>
									<td style="text-align: center;"><button class="btn btn-dark btn-xs" onClick='konfirmasi(<?= $odr->pjl_id ?>)' title="Konfirmasi"> <i class="fas fa-check-circle"></i></button></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="card-footer">
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="card" style="padding:15px 15px 15px 15px;">
				<h6 style="font-weight:bold"><i class="fas fa-chart-line"></i> Top 10 Penjualan Produk Tertinggi</h6>
				<select id="filter_tahun2" class="form-control filterr" onChange="filter_tahun2()">
					<option value="0">Pilih Tahun</option>
					<?php
					for ($thn = date('Y'); $thn > (date('Y') - 3); $thn--) {
					?>
						<option value="<?= $thn ?>"><?= $thn; ?></option>
					<?php
					} ?>
				</select>
				<div id="chartprodukcontainer">
					<canvas id="chartproduk" height="300px"></canvas>
				</div>
				<script>
					var thn = 0;

					function reset_grafik_produk() {
						$('#chartproduk').remove(); // this is my <canvas> element
						$('#chartprodukcontainer').append('<canvas id="chartproduk" height="300px"><canvas>');
					}

					function tampil_grafik_produk() {
						$.get("<?= base_url(); ?>Dashboard/grafik_produk/" + thn, {}, function(produk) {
							var prd = JSON.parse(produk);
							var bar = document.getElementById("chartproduk").getContext('2d');
							var myChart = new Chart(bar, {
								type: 'bar',
								data: {
									labels: prd.label,
									datasets: prd.dataset,
								},
								options: {
									maintainAspectRatio: false,
									scales: {
										yAxes: [{
											ticks: {
												beginAtZero: true
											}
										}],
										xAxes: [{
											ticks: {
												// Include a dollar sign in the ticks
												labelString: prd.dataset.label
											}
										}]
									},
									tooltips: {
										callbacks: {
											label: function(tooltipItem, data) {
												console.log(data.satuan);
												return Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
													return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
												}) + " ";
											}
										}
									}
								}
							});
						});
					}

					function filter_tahun2() {
						event.preventDefault();
						reset_grafik_produk();
						thn = $("#filter_tahun2").val();

						tampil_grafik_produk();
					}
					tampil_grafik_produk();
				</script>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card">
				<div class="card-header">
					<h6 style="font-weight:bold"><i class="fas fa-exclamation-circle"></i> Stok Hampir Habis</h6>
				</div>
				<div class="card-body" style="overflow-y: scroll; height: 420px">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<th>Material</th>
							<th>Sisa Stok</th>
						</thead>
						<tbody style="font-size:small;">
							<?php $i = 0;
							foreach ($stok as $idx => $s) { ?>
								<tr>
									<td style="width:70%;"><?= $s->mtl_nama ?></td>
									<td id="barisStok<?= $idx ?>"><?= $s->mtl_stok ?></td>
								</tr>
							<?php $i++;
							} ?>
							<input type="hidden" id="idx" value="<?= $i ?>">
						</tbody>
					</table>
				</div>
				<div class="card-footer">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_konfirm" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title"><i class="fas fa-exclamation-circle"></i> Konfirmasi pesanan ini</h6>
				<span type="button" aria-hidden="true" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_form()">&times;</span>
			</div>
			<form role="form col-lg" name="TambahEdit" id="frm_konfirm">
				<div class="modal-body form">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<input type="hidden" name="pjl_id" id="pjl_id2" value="">
								<select class="form-control" name="pjl_status" id="pjl_status2">
									<option value="2">Konfirmasi Pesanan</option>
									<option value="3">Tolak Pesanan</option>
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
						<th>Tanggal</th>
						<th>Konsumen</th>
						<th>Aksi</th>
					</thead>
					<tbody style="font-size:small;">
						<tr>
							<td id="mtl_nama"></td>
							<td id="qty"></td>
							<td id="satuan"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="submit" id="simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</button>
			</div>
		</div>
	</div>
</div>

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

<!-- Custom Java Script -->
<script>
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

	var index = $('#idx').val();

	for (let i = 0; i < index; i++) {
		var stok = $('#barisStok' + i).html();
		if (stok < 0) {
			document.getElementById("barisStok" + i).style.backgroundColor = '#FF4500';
		} else if (stok == 0) {
			document.getElementById("barisStok" + i).style.backgroundColor = '#FF8C00';
		} else if (stok < 5) {
			document.getElementById("barisStok" + i).style.backgroundColor = '#DAA520';
		} else {
			document.getElementById("barisStok" + i).style.backgroundColor = '#FFD700';
		}
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
					$("#modal_konfirm").modal("hide");
					window.location.reload();
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

	function detail(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "detail_pesanan/" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					console.log(dt[1]);
					$("#" + dt[0]).html(dt[1]['mtl_nama']);
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

	function reset_form() {
		$("#frm_konfirm")[0].reset();
	}

	$(document).ready(function() {});
</script>