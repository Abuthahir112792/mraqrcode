@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.home.home') }}
@stop


@section('loader')
    <div class="preloader" style="display: none">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@stop

@section('header')
@include('front.layouts.top_nav')
@stop

@section('content')

   
<section  style=" background: url(../cms_media/productimage/{{$getproductdetails->product_image_url}}) no-repeat center; background-size: cover;margin-top: 180px;" class=" h-500x  pos-relative">
        <div class="triangle-up pos-bottom"></div>
        <div class="container h-100">
                <div class="dplay-tbl">
                        
                </div><!-- dplay-tbl -->
        </div><!-- container -->
</section>


<section class="story-area left-text center-sm-text">
        <div class="container">
                <div class="heading">
                        @if($language == 'en')
                        <h2>{{$getproductdetails->en_category_title}}</h2>
                        <h5 class="mt-10 mb-30">{{$getproductdetails->en_product_title}}</h5>
                        <h5 class="mt-10 mb-30 color-primary">QR{{$getproductdetails->en_product_price}}</h5>
                        <p class="mx-w-700x mlr-auto">{{$getproductdetails->en_product_description}}</p>
                        @else
                        <h2>{{$getproductdetails->ar_category_title}}</h2>
                        <h5 class="mt-10 mb-30">{{$getproductdetails->ar_product_title}}</h5>
                        <h5 class="mt-10 mb-30 color-primary">QR{{$getproductdetails->ar_product_price}}</h5>
                        <p class="mx-w-700x mlr-auto">{{$getproductdetails->ar_product_description}}</p>
                        @endif        
                </div>

                
        </div><!-- container -->
</section>

@section('footer')
@include('front.layouts.footer')
@stop

<@stop
@section('javascript')
<script type="text/javascript">

   $(document).on('change','.language',function(e){
        
        var language = $(this).val();
        
                    $.ajax({
            type        : 'GET',
            url         : APP_URL + '/changelanguage/'+language,
            cache : false,
            processData: false
        }).done(function(response) {
            if(response.status == 1){
                 window.location.reload();;
            }else{
                alert(response.message)
            }
        });
       
    });
    </script>
    @stop