@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.home.home') }}
@stop
@section('css')
<style type="text/css">
    .delivery-method{
      display: flex;
    justify-content: center;
    overflow: hidden;
    cursor: pointer;
    }
  
    .delivery-method-item{
        padding: 20px;
      border-radius: 5px;

  }
     
    
    .delivery-method-item>div{
         font-size: 1.2rem;
     }
    
    .delivery-method-active{
         background-color: #1b88db;
         color: white;
}

.sc-cart-item-list {
    min-height: 50px;
}
.list-group {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    padding-left: 0;
    margin-bottom: 0;
}
.list-group-item:last-child {
    margin-bottom: 0;
    border-bottom-right-radius: .25rem;
    border-bottom-left-radius: .25rem;
}
.list-group-item:first-child {
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}
.list-group-item {
    position: relative;
    display: block;
    padding: .75rem 1.25rem;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.125);
}
.sc-cart-remove {
    background: transparent;
    border: none;
    font-size: 18px;
    position: absolute;
    top: 0;
    padding: 10px;
    right: 2px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}
.sc-cart-item img {
    margin-right: 10px;
    width: 60px;
}
img {
    vertical-align: middle;
    border-style: none;
}
h4.list-group-item-heading {
    font-size: 1rem;
}
.sc-cart-item-summary {
    text-align: right;
    margin-top: 5px;
    padding-top: 5px;
}

.sc-cart-item-qty {
    width: 55px;
    border-radius: 3px;
    font-size: 12px;
    padding: 4px 0 3px 6px;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
}

.modal-footer {
    display: -webkit-box;
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: end;
    justify-content: flex-end;
    padding: 1rem;
    border-top: 1px solid #e9ecef;
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

<!-- <section id="ourcart" style=" background: url(front/grocery/images/menuback.png) no-repeat center; background-size: cover;" > -->
<section id="ourcart">
        <div class="container">
                <div class="heading">
                        {{-- <a><img class="logo pb-5" src="front/grocery/images/logo.png" alt=""></a> --}}
                        <h2>{{ $language == 'en' ? 'Our Cart' : 'القائمة لدينا' }}</h2>
                        
                </div>


                <div class="row" dir="ltr" id="cartproductList">
                   
                
                </div><!-- row -->
                <div style="text-align: right;font-size: 1.5em;">        
                {{ $language == 'en' ? 'Subtotal' : 'المجموع الفرعي'}}: {{ $language == 'en' ? 'QR' : 'QR'}} <span class="total_aount" id="total_aount"></span>
                <h6 class="mt-20"><button class="btn-brdr-primary plr-25 clearall" id="clearall">{{ $language == 'en' ? 'CLEAR CART' : 'عربة واضحة'}}</button></h6>
                </div>
                <br/>
                <div class="delivery-method" >
                            <div class="delivery-method-item delivery-method-active select-home-delivery">
                                 <div>{{ $language == 'en' ? 'DINE-IN' : 'تناول الطعام في'}}</div>
                            </div>
                            <div class="delivery-method-item select-slef-pickup">
                                <div>{{ $language == 'en' ? 'TAKE AWAY' : 'يبعد'}}</div>
                            </div>

                </div>
                <br/>
                <div class="form-style-1">
                    <label>{{ $language == 'en' ? 'Mobile' : 'التليفون المحمول'}}</label>
                    <input type="Number" id="mobile_no " class=" mobile_no " name="mobile_no" placeholder="{{ $language == 'en' ? 'Please Enter Your Mobile Number' : 'الرجاء إدخال رقم هاتفك المحمول'}}" require>
                </div>
                <span style="color: red;display: none;" id="mobile_no_alert">{{ $language == 'en' ? 'Please Enter Your Mobile Number' : 'الرجاء إدخال رقم هاتفك المحمول'}}</span>
                <span></span>
                <div class="form-style-1">
                    <label>{{ $language == 'en' ? 'Name / Address' : 'عنوان اسم'}}</label>
                    <textarea id="address " class="h-200x  ptb-20 address" name="address" placeholder="{{ $language == 'en' ? 'Please Enter your Name / Address' : 'أدخل اسمك / عنوانك'}}" require></textarea> 
                </div>
                <span style="color: red;display: none;" id="address_alert">{{ $language == 'en' ? 'Please Enter your Name / Address' : 'أدخل اسمك / عنوانك'}}</span>
                <span></span>
                <div class="form-style-1">
                    <label>{{ $language == 'en' ? 'Description' : 'وصف'}}</label>
                    <textarea id="notes " class="h-200x  ptb-20 notes " name="notes" placeholder="{{ $language == 'en' ? 'Enter Your Description' : 'أدخل الوصف الخاص بك'}}" require></textarea>
                </div>
                
                <div class="modal-footer">
                <a class="logo" href="{{ route('front.home')}}"><button class="btn-brdr-primary plr-25" style="width: 225px">{{ $language == 'en' ? 'Back To Store' : 'عودة للمخزن'}}</button></a>
                <button class="btn btn-success plr-25 whatssend" id="whatssend"><i class="ion-social-whatsapp"></i> {{ $language == 'en' ? 'Order On Whatsapp' : 'اطلب على Whatsapp'}}</button>
                </div>

</section>

@section('footer')
@include('front.layouts.footer')
@stop

@stop
@section('javascript')
 <script src="{{ asset('front/js/cartview.js') }}"></script>
    @stop