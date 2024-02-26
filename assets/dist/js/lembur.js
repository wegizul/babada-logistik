var save_method; //for save method string
var table;
var tgl = null;

function drawTable() {
	$('#tabel-lembur').DataTable({
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
			"url": "ajax_list_lembur/" + tgl,
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

	var lembur_id = $("#lbr_id" + pegid).val();
	var lbr_tanggal = $("#lbr_tanggal" + pegid).val();
	var jam_mulai = $("#lbr_jam_mulai" + pegid).val();
	var jam_selesai = $("#lbr_jam_selesai" + pegid).val();
	var keterangan = $("#lbr_keterangan" + pegid).val();
	var target = $("#lbr_target" + pegid).val();
	var status = $("#lbr_status" + pegid).val();
	$.ajax({
		type: "POST",
		url: "simpan/" + pegid,
		data: "lbr_id=" + lembur_id + "&lbr_peg_id=" + pegid + "&lbr_tanggal=" + lbr_tanggal + "&lbr_jam_mulai=" + jam_mulai + "&lbr_jam_selesai=" + jam_selesai + "&lbr_keterangan=" + keterangan + "&lbr_target=" + target + "&lbr_status=" + status,
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

			var periode = $("#lbr_tanggal").val().split(" - ");
			var tgls = periode[0].split("/");
			tgl = tgls[2] + "-" + tgls[1] + "-" + tgls[0];
			drawTable();
		}, 100);
	});
	drawTable();
});