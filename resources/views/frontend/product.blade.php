@extends('layouts.frontend')

@section('content')
<div class="single-product-area section-padding-100 clearfix">
    <div class="container-fluid">
        <div id="produkdetail">

        </div>
        <div class="single_product_desc" style="margin-left:60%;">
            <div class="product-meta-data">
                <div class="line"></div>
                <form class="cart clearfix" id="form" name="form" method="post" action="{{ url('/formcart') }}">
                @csrf
                    <div class="cart-btn d-flex mb-50">
                        <p>Qty</p>
                        <div class="quantity">
                            <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                            <input type="number" class="qty-text" id="qty" step="1" min="1" max="300" name="qty" value="1">
                            <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <button type="submit" class="btn amado-btn" id="simpan">Add to cart</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/produkdetail.js') }}"></script>
{{-- <script src="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.('body').on('click','#simpan',function(e) {
            e.preventDefault();
            // $(this).hide();
            $.ajax({
                data: $('#form').serialize(),
                url: "{{ route('formcart.store') }}",
                type: "POST",
                success: function(data) {
                    $('#form').trigger("reset");
                },
                error: function(request, status, error) {
                    console.log(error);
                }
            });
        });
    });
</script> --}}
@endsection
