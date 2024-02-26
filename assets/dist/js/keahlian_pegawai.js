var save_method; //for save method string
var table;
var peg_id = $("#peg_id").val();

function drawTable() {
	$('#tabel-keahlian_pegawai').DataTable({
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
			"url": "../ajax_list_keahlian_pegawai/" + peg_id,
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

function tambah() {
	$("#ahl_id").val(0);
	$("frm_keahlian_pegawai").trigger("reset");
	$('#modal_keahlian_pegawai').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_keahlian_pegawai").submit(function (e) {
	e.preventDefault();
	$("#ahl_simpan").html("Menyimpan...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "POST",
		url: "../simpan",
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function (d) {
			var res = JSON.parse(d);
			var msg = "";
			if (res.status == 1) {
				toastr.success(res.desc);
				drawTable();
				reset_form();
				$("#modal_keahlian_pegawai").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#ahl_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#ahl_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});

});

$("#ok_info_ok").click(function () {
	$("#info_ok").modal("hide");
	drawTable();
});

$("#okKonfirm").click(function () {
	$(".utama").show();;
	$(".cadangan").hide();
	drawTable();
});

function hapus_keahlian_pegawai(id) {
	event.preventDefault();
	$("#ahl_id").val(id);
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_keahlian_pegawai(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "../cari",
		data: "ahl_id=" + id,
		dataType: "json",
		success: function (data) {
			$("#ahl_id").val(data.ahl_id);
			$("#ahl_peg_id").val(data.ahl_peg_id);
			$("#ahl_bidang_id").val(data.ahl_bidang_id);
			$("#ahl_nama").val(data.ahl_nama);
			$("#ahl_keterangan").val(data.ahl_keterangan);
			$("#ahl_penguasaan").val(data.ahl_penguasaan);
			$(".inputan").attr("disabled", false);
			$("#modal_keahlian_pegawai").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

function reset_form() {
	$("#ahl_id").val(0);
	$("#frm_keahlian_pegawai")[0].reset();
}

$("#yaKonfirm").click(function () {
	var id = $("#ahl_id").val();

	$("#isiKonfirm").html("Sedang menghapus data...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "GET",
		url: "../hapus/" + id,
		success: function (d) {
			var res = JSON.parse(d);
			var msg = "";
			if (res.status == 1) {
				toastr.success(res.desc);
				$("#frmKonfirm").modal("hide");
				drawTable();
			}
			else {
				toastr.error(res.desc + "[" + res.err + "]");
			}
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
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
	"autoAplog": true,
	opens: 'left'
});

$(document).ready(function () {
	drawTable();
});