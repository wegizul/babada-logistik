var save_method; //for save method string
var table;
var peg_id = $("#peg_id").val();

function drawTable() {
	$('#tabel-kontrak').DataTable({
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
			"url": "../ajax_list_kontrak/" + peg_id,
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
	$("#ktr_id").val(0);
	$("frm_kontrak").trigger("reset");
	$('#modal_kontrak').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_kontrak").submit(function (e) {
	e.preventDefault();
	$("#ktr_simpan").html("Menyimpan...");
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
				$("#modal_kontrak").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#ktr_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#ktr_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});

});

function get_divisi(id) {
	if (id < 3) {
		$("#divisi").show();
	} else {
		$("#divisi").hide();
	}
}

function hapus_kontrak(id) {
	event.preventDefault();
	$("#ktr_id").val(id);
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_kontrak(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "../cari",
		data: "ktr_id=" + id,
		dataType: "json",
		success: function (data) {
			var obj = Object.entries(data);
			obj.map((dt) => {
				if (dt[0] == "ktr_file") {
					$("#" + dt[0]).val(null);
				} else if (dt[0] == "ktr_tanggal") {
					var tgl = dt[1].split("-");
					$("#" + dt[0]).val(tgl[2] + "/" + tgl[1] + "/" + tgl[0]);
				} else if (dt[0] == "ktr_berlaku_mulai") {
					var tgl2 = dt[1].split("-");
					$("#" + dt[0]).val(tgl2[2] + "/" + tgl2[1] + "/" + tgl2[0]);
				} else if (dt[0] == "ktr_berlaku_sampai") {
					var tgl3 = dt[1].split("-");
					$("#" + dt[0]).val(tgl3[2] + "/" + tgl3[1] + "/" + tgl3[0]);
				} else {
					$("#" + dt[0]).val(dt[1]);
				}
			});
			$(".inputan").attr("disabled", false);
			$("#modal_kontrak").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

function reset_form() {
	$("#ktr_id").val(0);
	$("#frm_kontrak")[0].reset();
}

$("#yaKonfirm").click(function () {
	var id = $("#ktr_id").val();

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