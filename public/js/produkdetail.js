var grabedurl = window.location.pathname;
var url = "/api" + grabedurl;

$.ajax({
    url: url,
    dataType: "json",
    method: "GET",
    success: function(get) {
        $("#produkdetail").append(
            `
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-50">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item">Produk</li>
                            <li class="breadcrumb-item active" aria-current="page">${get.data.nama}</li>
                        </ol>
                    </nav>
                </div>
            </div>
             <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="single_product_thumb">
                        <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url('/assets/poto/${get.data.foto}');">
                                </li>
                                <li data-target="#product_details_slider" data-slide-to="1" style="background-image: url('/assets/poto/${get.data.foto}');">
                                </li>
                                <li data-target="#product_details_slider" data-slide-to="2" style="background-image: url('/assets/poto/${get.data.foto}');">
                                </li>
                                <li data-target="#product_details_slider" data-slide-to="3" style="background-image: url('/assets/poto/${get.data.foto}');">
                                </li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                        <img class="d-block w-100" src="/assets/poto/${get.data.foto}" alt="First slide">
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a class="gallery_img" href="/assets/poto/${get.data.foto}">
                                        <img class="d-block w-100" src="/assets/poto/${get.data.foto}" alt="Second slide">
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a class="gallery_img" href="/assets/poto/${get.data.foto}">
                                        <img class="d-block w-100" src="/assets/poto/${get.data.foto}" alt="Third slide">
                                    </a>
                                </div>
                                <div class="carousel-item">
                                    <a class="gallery_img" href="/assets/poto/${get.data.foto}">
                                        <img class="d-block w-100" src="/assets/poto/${get.data.foto}" alt="Fourth slide">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="single_product_desc">
                        <!-- Product Meta Data -->
                        <div class="product-meta-data">
                            <div class="line"></div>
                            <p class="product-price">Rp. ${get.data.harga}</p>
                            <a href="/shop/${get.data.slug}">
                                <h6>${get.data.nama}</h6>
                            </a>
                            <!-- Ratings & Review -->
                            <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                <div class="ratings">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                                <div class="review">
                                    <a href="#">Write A Review</a>
                                </div>
                            </div>
                            <!-- Avaiable -->
                            <p class="avaibility"><i class="fa fa-circle"></i> In Stock</p>
                        </div>
                        <div class="short_overview my-5">
                            <p>${get.data.konten}</p>
                        </div>
                        <!-- Add to Cart Form -->
                        <div id='formcart'>
                        </div>
                    </div>
                </div>
             `
        );
    }
});

$.ajax({
    url: url,
    dataType: "json",
    method: "GET",
    success: function(get) {
        $(".quantity").append(
            `
                <input type="hidden" name="id_produk" value="${get.data.id}" class="form-control">
            `
        );
    }
});
