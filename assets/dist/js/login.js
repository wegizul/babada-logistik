var base_link = $("#base_link").val();
$(function () {
    
    $('.list-inline li > a').click(function () {
        var activeForm = $(this).attr('href') + ' > form';
        //console.log(activeForm);
        $(activeForm).addClass('magictime swap');
        //set timer to 1 seconds, after that, unload the magic animation
        setTimeout(function () {
            $(activeForm).removeClass('magictime swap');
        }, 1000);
    });
	
});

$("#frm_login").submit(function(e){
	// var dataString = $("#frm_jabatan").serialize();
	e.preventDefault();
	$(".btn").attr("disabled", true);
	$.ajax({
       type: "POST",
		url: base_link+"Login/proses",
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function(d) 
        {
			var res = JSON.parse(d);
			// alert(d+ " - " + res.status);
			if (res.status == 1)
			{
				toastr.success('Login Berhasil!<br/>'+res.desc);
				setTimeout(function() {
					document.location.href="";
				},1000);
			}
			else
			{
				$(".btn").attr("disabled", false);
				toastr.error('Login Gagal!<br/>'+res.desc);
			}
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
			$(".btn").attr("disabled", false);
			toastr.error('Error! '+errorThrown);
        }
    });
	
});
