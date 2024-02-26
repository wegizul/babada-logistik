var save_method; //for save method string
var table;
var tgl = null;

function drawTable() {
	$('#tabel-absensi').DataTable({
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
			"url": "ajax_list_absensi/" + tgl,
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

	var absen_id = $("#abs_id" + pegid).val();
	var pegnama = $("#peg_nama" + pegid).val();
	var tanggal = $("#abs_tanggal" + pegid).val();
	var jam_masuk = $("#abs_jam_masuk" + pegid).val();
	var jam_pulang = $("#abs_jam_pulang" + pegid).val();
	var keterangan = $("#abs_keterangan" + pegid).val();
	var status = $("#abs_status" + pegid).val();
	$.ajax({
		type: "POST",
		url: "simpan/" + pegid,
		data: "abs_id=" + absen_id + "&abs_peg_id=" + pegid + "&abs_peg_nama=" + pegnama + "&abs_tanggal=" + tanggal + "&abs_jam_masuk=" + jam_masuk + "&abs_jam_pulang=" + jam_pulang + "&abs_keterangan=" + keterangan + "&abs_status=" + status,
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

			var periode = $("#abs_tanggal").val().split(" - ");
			var tgls = periode[0].split("/");
			tgl = tgls[2] + "-" + tgls[1] + "-" + tgls[0];
			drawTable();
		}, 100);
	});
	drawTable();
});