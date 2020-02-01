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
                    <div class="single-products-catagory clearfix">
                    <a href="/produk/${value.slug}">
                        <img src="assets/poto/${value.foto}" alt="">
                        <!-- Hover Content -->
                        <div class="hover-content">
                            <div class="line"></div>
                            <p>${value.harga}</p>
                            <h4>${value.nama}</h4>
                        </div>
                    </a>
                </div>
                `
                );
            });
        }
    });

    $.ajax({
        url: url,
        method: "GET",
        datatype: "json",
        success: function(berhasil) {
            $.each(berhasil.data.kategori, function(key, value) {
                $("#kategori").append(
                    `
                    <li><a href="/shop/${value.slug}"> ${value.nama} </a></li>
                `
                );
            });
        }
    });

    $.ajax({
        url: url,
        method: "GET",
        datatype: "json",
        success: function(berhasil) {
            $.each(berhasil.data.gallery, function(key, value) {
                $("#produk").append(
                    `
                    <div class="col-12 col-sm-6 col-md-12 col-xl-6">
                    <div class="single-product-wrapper">
                        <!-- Product Image -->
                        <div class="product-img">
                            <img src="/assets/poto/${value.foto}" alt="">
                            <!-- Hover Thumb -->
                            <img class="hover-img" src="/assets/poto/${value.foto}" alt="">
                        </div>

                        <!-- Product Description -->
                        <div class="product-description d-flex align-items-center justify-content-between">
                            <!-- Product Meta Data -->
                            <div class="product-meta-data">
                                <div class="line"></div>
                                <p class="product-price">Rp. ${value.harga}</p>
                                <a href="/produk/${value.slug}">
                                    <h6>${value.nama}</h6>
                                </a>
                            </div>
                            <!-- Ratings & Cart -->
                            <div class="ratings-cart text-right">
                                <div class="ratings">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="cart">
                                    <a href="cart.html" data-toggle="tooltip" data-placement="left" title="Add to Cart"><img src="/assets/frontend/img/core-img/cart.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `
                );
            });
        }
    });
})(jQuery);

