<style>
	.filterr {
		display: block;
		margin-left: auto;
		margin-right: auto;
		width: 50%;
	}
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="padding:15px 15px 15px 15px;">
				<h6 style="text-align:center; font-weight:bold">Grafik Jumlah Penjualan perbulan</h6>
				<select id="filter_tahun" class="filterr" onChange="filter_tahun()">
					<option value="0">== Filter Tahun ==</option>
					<?php
					for ($thn = date('Y'); $thn > (date('Y') - 3); $thn--) {
					?>
						<option value="<?= $thn ?>"><?= $thn; ?></option>
					<?php
					} ?>
				</select>
				<div id="chartpenjualancontainer">
					<canvas id="chartpenjualan" height="345"></canvas>
				</div>
				<script>
					var thn = 0;

					function reset_grafik_penjualan() {
						$('#chartpenjualan').remove(); // this is my <canvas> element
						$('#chartpenjualancontainer').append('<canvas id="chartpenjualan" height="300"><canvas>');
					}

					function tampil_grafik_penjualan() {
						$.get("<?= base_url(); ?>Dashboard/grafik_penjualan/" + thn, {}, function(dklkelthn) {
							var klkel = JSON.parse(dklkelthn);
							var ctx = document.getElementById("chartpenjualan").getContext('2d');
							var myChart = new Chart(ctx, {
								type: 'bar',
								data: {
									labels: klkel.label,
									datasets: klkel.dataset
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
												labelString: klkel.dataset.label
											}
										}]
									},
									tooltips: {
										callbacks: {
											label: function(tooltipItem, data) {
												return Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
													return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
												}) + " Item";
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
	</div>
</div>
<div class="row">

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
	var save_method; //for save method string
	var table;

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

	const notifError = "<?= $this->session->flashdata('error') ?>";
	const notifSuccess = "<?= $this->session->flashdata('success') ?>";

	$(document).ready(function() {
		if (notifError) {
			toastr.error(notifError);
		} else if (notifSuccess) {
			toastr.success(notifSuccess);
		}
	});
</script>