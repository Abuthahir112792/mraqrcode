<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use App\Menu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function cartview(){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
            
        }
        $is_login = !empty($token) ? 1 : 0;
        $user_details = User::where('role','shop_keeper')->first();
        $order_allow = 0;
        $language = $user_details->language;
        if(!empty($user_details) && $is_login == 1){
            $order_allow = $user_details->order_allow;
            $language = $user_details->language;
        }

       
        
        return view('front.cartview',compact('is_login','language'));
    }

    public function getcartproduct($storage){
        $cartproductharray = array();
        $total_aount = array();
        $cartproductid = explode(',', $storage);
        $user_details = User::select('language')->where('role','shop_keeper')->first();
        foreach ($cartproductid as $cartproductid) {
            
            $getcartproduct = Product::select('product.*')->where('product.id',$cartproductid)->first();
            $cartproductharray[] = $getcartproduct;
            $total_aount[] = $getcartproduct->en_product_price;
            }
       
            return response()->json(['status' => 1,'status_code' => 200,'cartproductharray' => $cartproductharray, 'user_details'=>$user_details->language, 'total_aount'=>array_sum($total_aount)]);
        
       
    }

    
}
