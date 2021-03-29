@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.home.home') }}
@stop

@section('css')
<style type="text/css">

    /* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  height: 80%;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}

/* The Close Button */
.closes {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
  cursor: pointer;
}

.closs:hover,
.closes:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
.float-btn {
    position: fixed;
    width: 70px;
    height: 70px;
    bottom: 65px;
    background-color: #706f73;
    color: #FFF;
    border-radius: 50px;
    text-align: right;
    box-shadow: 2px 2px 3px rgb(116, 114, 114);
    transition: 0.4s ease-in-out;
    z-index: 10;
    right: 32px

}
@media (max-width: 576px) {
  .float-btn {
    bottom: 65px;
    right: 10px
  }
}
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.flot-icon-wrapper {
    position: relative;
}
.flot-icon-wrapper span {
    position: absolute;
    padding: 5px;
    height: 25px;
    min-width: 25px;
    top: -10px;
    left: 10px;
    border-radius: 50px;
}
.align-items-centers {
    -webkit-box-align: center!important;
    -ms-flex-align: center!important;
    align-items: center!important;
}
.justify-content-centers {
    -webkit-box-pack: center!important;
    -ms-flex-pack: center!important;
    justify-content: center!important;
}

.bg-successs {
    background-color: #28a745!important;
}
.my-float {
    font-size: 25px;
    color: #fff;
}
#search {
    position: relative;
    padding-top: 20px;
    margin: -20px auto 0;
}
#search label {
    position: absolute;
    left: 13px;
    top: 26px;
    font-size: 23px;
}
#search #product_key {
    
    
}
</style>
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

    <!-- banner -->
   
<section  class=" h-500x  pos-relative">
        <div class="triangle-up pos-bottom"></div>
        <div class="container h-100">
                <div class="dplay-tbl">
                        <div class="dplay-tbl-cell center-text color-white">

                               <a class="logo" href="{{ route('front.home')}}">  <img  src="front/grocery/images/logo.png" alt="Logo"></a>
                                <h2 style="color: black" class="mt-30 mb-15">Opera Menu</h2>
                        </div><!-- dplay-tbl-cell -->
                </div><!-- dplay-tbl -->
        </div><!-- container -->
</section>




<section id="ourmenu"  >
        <div class="container">
                <div class="heading">
                        {{-- <a><img class="logo pb-5" src="front/grocery/images/logo.png" alt=""></a> --}}
                        <h2>{{ $language == 'en' ? 'Our Menu' : 'القائمة لدينا' }}</h2>
                        <div class="form-style-1">
                        <select id="menu_id " class="mb-20 menu_id " name="menu_id" require style="box-shadow: none !important;border-radius: 50px;padding-left: 43px;padding-right: 43px;">
                                  <option value="">Select</option>
                        </select>
                        </div>
                        <div class="form-style-1" id="search">
                        <label for="product_key" style="display: inline-block;margin-bottom: .5rem;">
                          <i class = "icon icon ion-ios-search"></i>
                        </label>  
                        <input id="product_key " class="mb-20 product_key " name="product_key" placeholder="Product Search" autocomplete="off" spellcheck="false" autocorrect="off" tabindex="1" require style="box-shadow: none !important;border-radius: 50px;padding-left: 43px;padding-right: 43px;">
                        </div>
                </div>
                
                <div class="row">
                        <div class="col-sm-12">
                                <ul class="selecton brdr-b-primary mb-70 categorylist">
                                       
                                </ul>
                        </div><!--col-sm-12-->
                </div><!--row-->

                <div class="row" dir="ltr" id="categoryviaproductList">
                   
                
                </div><!-- row -->
<!-- <div id="test_id"></div> -->
<button class="btn float-btn cartdetails" data-toggle="modal" id="cartdetails" style="border-radius: 50%;font-size: 19px;height: 55px;width: 55px;display: flex;justify-content: center;align-items: center;
    box-shadow: 0px 0px 6px 1px rgba(0,0,0,0.5)">
  <div class="flot-icon-wrapper">
    <div class="badge-wrapper">
      <span class="bg-successs  justify-content-centers align-items-centers sc-cart-count" id=item_count style="display: none"></span>
    </div>
    <i class = "icon icon ion-ios-cart"></i>
  </div>
</button>

</section>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="closes">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>

@section('footer')
@include('front.layouts.footer')
@stop

@stop
@section('javascript')
 <script src="{{ asset('front/js/firstmenu.js') }}"></script>
 

    @stop