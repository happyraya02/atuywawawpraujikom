@extends('layouts.frontend')

@section('content')
<div class="single-product-area section-padding-100 clearfix">
        <div class="container-fluid">
            <div id="produkdetail">

            </div>
            <div class="single_product_desc" style="margin-left:60%;">
                    <div class="product-meta-data">
                        <div class="line"></div>
                    <form class="cart clearfix" id="form" name="form" method="post" action="{{ route('formcart.store') }}">
                        @csrf
                            <div class="cart-btn d-flex mb-50">
                                <p>Qty</p>
                                <div class="quantity">
                                    <span class="qty-minus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
                                    <input type="number" class="qty-text" id="qty" step="1" min="1" max="300" name="quantity" value="1">
                                    <span class="qty-plus" onclick="var effect = document.getElementById('qty'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-caret-up" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <button type="submit" name="addtocart" class="btn amado-btn" id="simpan">Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('js')
    <script src="{{asset('js/produkdetail.js')}}"></script>
    {{-- <script src="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    </script> --}}
@endsection
