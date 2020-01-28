(function($) {
    var grabedurl = window.location.pathname;
    var url = "/api" + grabedurl;

    $.ajax({
        url: url,
        method: "GET",
        datatype: "json",
        success: function(berhasil) {
            $.each(berhasil.data, function(key, value) {
                $("#latest").append(
                    `
                    <div class="col-lg-3 col-md-6 col-sm-6 single-blog">
                    <div class="thumb">
                        <img class="img-fluid" src="assets/poto/${value.foto}" alt="">
                    </div>
                    <p class="date">${value.harga}</p>
                    <a href="blog-single"><h4>${value.nama}</h4></a>
                    <p> ${value.konten}
                    </p>
                </div>
                `
                );
            });
        }
    });
})(jQuery);
