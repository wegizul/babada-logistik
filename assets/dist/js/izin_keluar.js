var save_method; //for save method string
var table;
var tgl = null;

function drawTable() {
	$('#tabel-izin_keluar').DataTable({
		"destroy": true,
		dom: 'Bfrtip',
		lengthMenu: [
			[10, 25, 50, -1],
			['10 rows', '25 rows', '50 rows', 'Show all']
		],
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
		],
		// "oLanguage": {
		// "sProcessing": '<center><img src="<?= base_url("assets/");?>assets/img/fb.gif" style="width:2%;"> Loading Data</center>',
		// },
		"responsive": true,
		"sort": true,
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"order": [], //Initial no order.
		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "ajax_list_izin_keluar/" + tgl,
			"type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
		],
		"initComplete": function (settings, json) {
			$("#process").html("<i class='glyphicon glyphicon-search'></i> Process")
			$(".btn").attr("disabled", false);
			$("#isidata").fadeIn();
		}
	});
}

function simpan(pegid) {

	var izin_id = $("#izn_id" + pegid).val();
	var izn_tanggal = $("#izn_tanggal" + pegid).val();
	var jam_keluar = $("#izn_jam_keluar" + pegid).val();
	var jam_kembali = $("#izn_jam_kembali" + pegid).val();
	var keperluan = $("#izn_keperluan" + pegid).val();
	$.ajax({
		type: "POST",
		url: "simpan/" + pegid,
		data: "izn_id=" + izin_id + "&izn_peg_id=" + pegid + "&izn_tanggal=" + izn_tanggal + "&izn_jam_keluar=" + jam_keluar + "&izn_jam_kembali=" + jam_kembali + "&izn_keperluan=" + keperluan,
		dataType: "json",
		success: function (res) {
			var msg = "";
			if (res.status == 1) {
				toastr.success(res.desc);
				drawTable();
			}
			else {
				toastr.error(res.desc);
			}
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

$(document).ready(function () {
	$('.tgl').daterangepicker({
		locale: {
			format: 'DD/MM/YYYY'
		},
		showDropdowns: true,
		singleDatePicker: true,
		"autoAplog": true,
		opens: 'left'
	}).on('apply.daterangepicker', function (ev, picker) {
		setTimeout(function () {

			var periode = $("#izn_tanggal").val().split(" - ");
			var tgls = periode[0].split("/");
			tgl = tgls[2] + "-" + tgls[1] + "-" + tgls[0];
			drawTable();
		}, 100);
	});
	drawTable();
});