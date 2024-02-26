var save_method; //for save method string
var table;
var peg_id = $("#peg_id").val();

function drawTable() {
	$('#tabel-rumah_pegawai').DataTable({
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
			"url": "../ajax_list_rumah_pegawai/" + peg_id,
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
	$("#rmh_id").val(0);
	$("frm_rumah_pegawai").trigger("reset");
	$('#modal_rumah_pegawai').modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

$("#frm_rumah_pegawai").submit(function (e) {
	e.preventDefault();
	$("#rmh_simpan").html("Menyimpan...");
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
				$("#modal_rumah_pegawai").modal("hide");
			}
			else {
				toastr.error(res.desc);
			}
			$("#rmh_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
		},
		error: function (jqXHR, namaStatus, errorThrown) {
			$("#rmh_simpan").html("Simpan");
			$(".btn").attr("disabled", false);
			alert('Error get data from ajax');
		}
	});

});

function get_kabkota(id) {
	var kbkt = decodeURIComponent(id);
	$.get("get_kabupaten/" + kbkt, {}, function (data) {
		$("#rmh_kabupaten").html(data);
	});
}
function get_kecamatan(id2) {
	var kec = decodeURIComponent(id2);
	$.get("get_kecamatan/" + kec, {}, function (data2) {
		$("#rmh_kecamatan").html(data2);
	});
}
function get_keldes(id3) {
	var klds = decodeURIComponent(id3);
	$.get("get_kelurahan/" + klds, {}, function (data3) {
		$("#rmh_keldes").html(data3);
	});
}

function hapus_rumah_pegawai(id) {
	event.preventDefault();
	$("#rmh_id").val(id);
	$("#jdlKonfirm").html("Konfirmasi hapus data");
	$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
	$("#frmKonfirm").modal({
		show: true,
		keyboard: false,
		backdrop: 'static'
	});
}

function ubah_rumah_pegawai(id) {
	event.preventDefault();
	$.ajax({
		type: "POST",
		url: "../cari",
		data: "rmh_id=" + id,
		dataType: "json",
		success: function (data) {
			$("#rmh_id").val(data.rmh_id);
			$("#rmh_peg_id").val(data.rmh_peg_id);
			$("#rmh_jrm_id").val(data.rmh_jrm_id);
			$("#rmh_tipe").val(data.rmh_tipe);
			$("#rmh_jml_lantai").val(data.rmh_jml_lantai);
			$("#rmh_status").val(data.rmh_status);
			$("#rmh_alamat").val(data.rmh_alamat);
			$("#rmh_rt").val(data.rmh_rt);
			$("#rmh_rw").val(data.rmh_rw);
			$("#rmh_provinsi").val(data.rmh_provinsi);
			$("#rmh_kabupaten").val(data.rmh_kabupaten);
			$("#rmh_kecamatan").val(data.rmh_kecamatan);
			$("#rmh_keldes").val(data.rmh_keldes);
			// var obj = Object.entries(data);
			// obj.map((dt) => {
			// 	if (dt[0] == "kry_tgl_lahir")
			// 	{
			// 		var tgl = dt[1].split("-");
			// 		$("#"+dt[0]).val(tgl[2]+"/"+tgl[1]+"/"+tgl[0]);
			// 	}
			// 	else 
			// 	{
			// 		$("#"+dt[0]).val(dt[1]);
			// 	}
			// });
			$(".inputan").attr("disabled", false);
			$("#modal_rumah_pegawai").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
			return false;
		}
	});
}

function reset_form() {
	$("#rmh_id").val(0);
	$("#frm_rumah_pegawai")[0].reset();
}

$("#yaKonfirm").click(function () {
	var id = $("#rmh_id").val();

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