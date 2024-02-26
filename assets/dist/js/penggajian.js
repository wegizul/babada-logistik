var save_method; //for save method string
var table;
var bln = null;
var thn = null;

function drawTable() {
	$('#tabel-penggajian').DataTable({
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
			"url": "ajax_list_penggajian/" + bln + "/" + thn,
			"type": "POST"
		},
		//Set column definition initialisation properties.
		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
			{
				"targets": [5, 6, 7], //last column
				"className": "text-right", //set not orderable
			},
		],
		"initComplete": function (settings, json) {
			$("#process").html("<i class='glyphicon glyphicon-search'></i> Process")
			$(".btn").attr("disabled", false);
			$("#isidata").fadeIn();
		}
	});
}

function pencairan() {
	$("frm_penggajian").trigger("reset");
	$.get("konfirmasi/" + bln + "/" + thn, {}, function (data) {
		$("#konfirmasi_pencairan").html(data);
	});
	$('#modal_penggajian').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_penggajian").submit(function (e) {
	e.preventDefault();
	$("#gji_simpan").html("Menyimpan...");
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
				$("#modal_penggajian").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#gji_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#gji_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});

});

function hapus_penggajian(id) {
	event.preventDefault();
	$("#gji_id").val(id);
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_penggajian(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "cari",
		data: "gji_id=" + id,
		dataType: "json",
		success: function (data) {
			var obj = Object.entries(data);
			obj.map((dt) => {
				$("#" + dt[0]).val(dt[1]);
			});
			$(".inputan").attr("disabled", false);
			$("#modal_penggajian").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

function cetak() {
}

function reset_form() {
	$("#gji_id").val(0);
	$("#frm_penggajian")[0].reset();
}

$("#yaKonfirm").click(function () {
	var id = $("#gji_id").val();

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

function filter_bulan() {
	var filter = $("#filter_bulan").val().split(".");
	thn = filter[0];
	bln = filter[1];

	var link = $("#cetaksemua").attr("link");
	$("#cetaksemua").attr("href", link + "/" + bln + "/" + thn);
	drawTable();
}

$(document).ready(function () {
	drawTable();
});
