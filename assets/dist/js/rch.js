var path = window.location.pathname.split("/");
// var base_link = window.location.protocol + "//" + window.location.hostname + ":" + window.location.port + "/" + path[1] + "/";
var x;
var n = 0;
var base_link = $("#base_link").val();

function buka_changelog() {
	event.preventDefault();
	$.ajax({
		url: base_link + "Changelog.txt",
		dataType: "text",
		success: function (data) {
			console.log(data);
			var string = data.replace(/\n/g, "<br>");
			$("#pesan_info_ok").html(string);
			$('#info_ok').modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
		}
	});

}

function getMenu(key) {
	switch (key) {
		case 27: document.location.href = "../Dashboard/tampil"; break;
		case 113: document.location.href = "../Kasir/tampil"; break;
		case 115: document.location.href = "../LaporanKas/tampil"; break;
		case 118: document.location.href = "../Pengeluaran/tampil"; break;
		case 120: cetakulang(localStorage.getItem("trs")); break;
		case 121: document.location.href = "../Member/tampil"; break;
	}
}

function cetakulang(ok) {
	if (ok) {
		$.get("../Kasir/cetak/" + ok, {}, function (d) {
			const mywindow = window.open('', 'Print', 'height=600,width=1000');

			mywindow.document.write('<html><head><title>Print</title>');
			mywindow.document.write('</head><body >');
			mywindow.document.write(d);
			mywindow.document.write('</body></html>');

			mywindow.document.close();
			mywindow.focus();
			// mywindow.print();
			// setTimeout(function() {
			// mywindow.close();
			// }, 5000);
		});
	}
	else {
		alert("Belum ada transarsi pada perangkat ini!");
	}
}

$(document).ready(function () {
	// $("body").keypress(function(e) {
	// getMenu(e.keyCode);
	// });
	$("body").keyup(function (e) {
		getMenu(e.keyCode);
	});
	$("#up_passlama").focusout(function () {
		var isi = $(this).val();
		var nama = $(this).attr("nama");
		alert(nama);
		if (isi == "") {
			$(this).prop("tooltiptext", nama + "tidak boleh kosong");
			$(this).tooltip();
		}
	});
	$("#chkNotif").click(function () {
		$.get(base_link + "Dashboard/notif_detail", {}, function (d) {
			$("#ntfDetail").html(d);
		});
	});

	// x = setInterval(function() {	
	// $.get(base_link+"Dashboard/notif", {}, function(d) {
	// if (d>0)
	// {
	// if (d>n)
	// {
	// n = d;
	// $("#ntfSound")[0].play();
	// }
	// $("#ntfInfo").html(d);
	// $("#ntfInfo").removeClass("label-default");
	// $("#ntfInfo").addClass("label-danger");
	// }
	// else 
	// {
	// $("#ntfInfo").html(0);
	// $("#ntfInfo").removeClass("label-danger");			
	// $("#ntfInfo").addClass("label-default");
	// }
	// });
	// },1000);
	// $("#up_passlama").click(function(){
	// var nama = $(this).attr("nama");
	// $(this).attr("title", nama+"tidak boleh kosong");
	// alert(nama);
	// $(this).tooltip();
	// });
});