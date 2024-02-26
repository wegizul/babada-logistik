var save_method; //for save method string
var table;

function drawTable() {
	$('#tabel-pengguna').DataTable({
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
			"url": "ajax_list_pengguna/",
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

function log_tambah() {
	reset_form();
	$("#log_id").val(0);
	$("frm_pengguna").trigger("reset");
	$('#modal_pengguna').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_pengguna").submit(function (e) {
	e.preventDefault();
	$("#log_simpan").html("Menyimpan...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "POST",
		url: "simpan",
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
				$("#modal_pengguna").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#log_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#log_simpan").html("Simpan");
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

function hapus_pengguna(id) {
	event.preventDefault();
	$("#log_id").val(id);
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_pengguna(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "cari",
		data: "log_id=" + id,
		dataType: "json",
		success: function (data) {
			$("#log_id").val(data.log_id);
			$("#log_nama").val(data.log_nama);
			$("#log_user").val(data.log_user);
			$("#log_level").val(data.log_level);
			$(".inputan").attr("disabled", false);
			$("#modal_pengguna").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

function reset_form() {
	$("#log_id").val(0);
	$("#frm_pengguna")[0].reset();
}

$("#showPass").click(function () {
	var st = $(this).attr("st");
	if (st == 0) {
		$("#log_passnya").attr("type", "text");
		$("#matanya").removeClass("fa-eye");
		$("#matanya").addClass("fa-eye-slash");
		$(this).attr("st", 1);
	}
	else {
		$("#log_passnya").attr("type", "password");
		$("#matanya").removeClass("fa-eye-slash");
		$("#matanya").addClass("fa-eye");
		$(this).attr("st", 0);
	}
});

$("#yaKonfirm").click(function () {
	var id = $("#log_id").val();

	$("#isiKonfirm").html("Sedang menghapus data...");
	$(".btn").attr("disabled", true);
	$.ajax({
		type: "GET",
		url: "hapus/" + id,
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