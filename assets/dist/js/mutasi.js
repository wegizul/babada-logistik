var save_method; //for save method string
var table;
var peg_id = $("#peg_id").val();

function drawTable() {
	$('#tabel-mutasi').DataTable({
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
			"url": "../ajax_list_mutasi/" + peg_id,
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
	$("#mut_id").val(0);
	$("frm_mutasi").trigger("reset");
	$('#modal_mutasi').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_mutasi").submit(function (e) {
	e.preventDefault();
	$("#mut_simpan").html("Menyimpan...");
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
				$("#modal_mutasi").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#mut_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#mut_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});

});

function get_divisi(id) {
	var jns = decodeURIComponent(id);
	$.get("../get_divisi/" + jns, {}, function (data) {
		$("#mut_div_tujuan").html(data);
	});
}

function cari_jabatan(id2, idpeg) {
	var jns2 = decodeURIComponent(id2);
	$.get("../cari_jabatan/" + jns2 + "/" + idpeg, {}, function (data2) {
		$("#mut_jabatan").html(data2);
	});
}

function hapus_mutasi(id) {
	event.preventDefault();
	$("#mut_id").val(id);
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_mutasi(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "../cari",
		data: "mut_id=" + id,
		dataType: "json",
		success: function (data) {
			var obj = Object.entries(data);
			obj.map((dt) => {
				if (dt[0] == "mut_tgl_mutasi") {
					var tgl = dt[1].split("-");
					$("#" + dt[0]).val(tgl[2] + "/" + tgl[1] + "/" + tgl[0]);
				}
				else {
					$("#" + dt[0]).val(dt[1]);
				}
			});
			$(".inputan").attr("disabled", false);
			$("#modal_mutasi").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

function reset_form() {
	$("#mut_id").val(0);
	$("#frm_mutasi")[0].reset();
}

$("#yaKonfirm").click(function () {
	var id = $("#mut_id").val();

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