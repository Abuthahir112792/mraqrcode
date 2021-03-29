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


class HomeController extends Controller
{
    public function index(){
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

       
        
        return view('front.home',compact('is_login','user_details','order_allow','language'));
    }

    public function firstmenu(){
        $user_details = User::select('language')->where('role','shop_keeper')->first();
        $menu = Menu::where('menu_status','Active')->get();
        
        if($user_details->language == 'en'){
        $menuoutput = '<option value="">Select</option>';
        foreach($menu as $menu)
        {
        $menuoutput .= '<option value="'.$menu->id.'">'.$menu->en_menu_title.'</option>';
        }
        }
        else{
          $menuoutput = '<option value="">تحديد</option>';
        foreach($menu as $menu)
        {
        $menuoutput .= '<option value="'.$menu->id.'">'.$menu->ar_menu_title.'</option>';
        }  
        }

        $getmenufirstid = Menu::where('menu_status','Active')->orderBy('id', 'ASC')->skip(0)->take(1)->first();
        $cms_data['menufirstid'] = array();
        if(!empty($getmenufirstid)){

            $cms_data['menufirstid'] = $getmenufirstid->id;
        }

        $getcategoryList = Category::where('category_status','Active')->where('menu_id',$getmenufirstid->id)->get();
        $cms_datacategoryList = "";
        if($user_details->language == 'en'){
        if(!empty($getcategoryList)){
            foreach($getcategoryList as $getcategoryList)
            {
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a id="categoryid'.$getcategoryList->id.'" class="categoryid" data-select="'.$getcategoryList->id.'"><img style="height:50px;width:50px;" src="cms_media/categoryimage/'.$getcategoryList->category_image_url.'"><br><b>'.$getcategoryList->en_category_title.'</b></a></li>';
            }
        }
        else{
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a class="active" href="#" data-select="*"><b>No</b></a></li>';
        }
        }
        else{
            if(!empty($getcategoryList)){
            foreach($getcategoryList as $getcategoryList)
            {
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a id="categoryid'.$getcategoryList->id.'" class="categoryid" data-select="'.$getcategoryList->id.'"><img style="height:50px;width:50px;" src="cms_media/categoryimage/'.$getcategoryList->category_image_url.'"><br><b>'.$getcategoryList->ar_category_title.'</b></a></li>';
            }
        }
        else{
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a class="active" href="#" data-select="*"><b>لا</b></a></li>';
        }
        }
        $categoryid = Category::select('id')->where('category_status','Active')->where('menu_id',$getmenufirstid->id)->orderBy('id', 'ASC')->skip(0)->take(1)->first();
        $getcategoryviaproductList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('category_id',$categoryid->id)->where('product_status','Active')->select('product.*', 'category.category_status')->get()->toArray();
        $cms_data['categoryviaproductList'] = array();
        if(!empty($getcategoryviaproductList)){

            $cms_data['categoryviaproductList'] = $getcategoryviaproductList;
        }
       
            return response()->json(['status' => 1,'status_code' => 200,'cms_data' => $cms_data,'menuoutput' => $menuoutput,'cms_datacategoryList' => $cms_datacategoryList, 'categoryid'=>$categoryid->id, 'user_details'=>$user_details->language]);
        
       
    }

    public function menuwise($id){
        $user_details = User::select('language')->where('role','shop_keeper')->first();
        $menu = Menu::where('menu_status','Active')->get();
        if($user_details->language == 'en'){
        $menuoutput = '<option value="">Select</option>';
        foreach($menu as $menu)
        {
        $menuoutput .= '<option value="'.$menu->id.'">'.$menu->en_menu_title.'</option>';
        }
        }
        else{
            $menuoutput = '<option value="">تحديد</option>';
        foreach($menu as $menu)
        {
        $menuoutput .= '<option value="'.$menu->id.'">'.$menu->ar_menu_title.'</option>';
        }
        }

        $getmenufirstid = Menu::where('menu_status','Active')->where('id',$id)->first();
        $cms_data['menufirstid'] = array();
        if(!empty($getmenufirstid)){

            $cms_data['menufirstid'] = $getmenufirstid->id;
        }

        $getcategoryList = Category::where('category_status','Active')->where('menu_id',$getmenufirstid->id)->get();
        $cms_datacategoryList = "";
        if($user_details->language == 'en'){
        if(!empty($getcategoryList)){
            foreach($getcategoryList as $getcategoryList)
            {
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a  id="categoryid'.$getcategoryList->id.'" class="categoryid" data-select="'.$getcategoryList->id.'"><img style="height:50px;width:50px;" src="cms_media/categoryimage/'.$getcategoryList->category_image_url.'"><br><b>'.$getcategoryList->en_category_title.'</b></a></li>';
            }
        }
        else{
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a class="active" href="#" data-select="*"><b>No</b></a></li>';
        }
        }
        else{
            if(!empty($getcategoryList)){
            foreach($getcategoryList as $getcategoryList)
            {
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a  id="categoryid'.$getcategoryList->id.'" class="categoryid" data-select="'.$getcategoryList->id.'"><img style="height:50px;width:50px;" src="cms_media/categoryimage/'.$getcategoryList->category_image_url.'"><br><b>'.$getcategoryList->ar_category_title.'</b></a></li>';
            }
        }
        else{
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a class="active" href="#" data-select="*"><b>لا</b></a></li>';
        }
        }

        $categoryid = Category::select('id')->where('category_status','Active')->where('menu_id',$getmenufirstid->id)->orderBy('id', 'ASC')->skip(0)->take(1)->first();
        $getcategoryviaproductList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('category_id',$categoryid->id)->where('product_status','Active')->select('product.*', 'category.category_status')->get()->toArray();
        $cms_data['categoryviaproductList'] = array();
        if(!empty($getcategoryviaproductList)){

            $cms_data['categoryviaproductList'] = $getcategoryviaproductList;
        }
       
            return response()->json(['status' => 1,'status_code' => 200,'cms_data' => $cms_data,'menuoutput' => $menuoutput,'cms_datacategoryList' => $cms_datacategoryList, 'categoryid'=>$categoryid->id, 'user_details'=>$user_details->language]);
        
       
    }

    public function categorywise($categoryid){
        
        $user_details = User::select('language')->where('role','shop_keeper')->first();
        $categorymenuid = Category::select('menu_id')->where('id',$categoryid)->first();

        $getcategoryList = Category::where('category_status','Active')->where('menu_id',$categorymenuid->menu_id)->get();
        $cms_datacategoryList = "";
        if($user_details->language == 'en'){
        if(!empty($getcategoryList)){
            foreach($getcategoryList as $getcategoryList)
            {
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a  id="categoryid'.$getcategoryList->id.'" class="categoryid" data-select="'.$getcategoryList->id.'"><img style="height:50px;width:50px;" src="cms_media/categoryimage/'.$getcategoryList->category_image_url.'"><br><b>'.$getcategoryList->en_category_title.'</b></a></li>';
            }
        }
        else{
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a class="active" href="#" data-select="*"><b>No</b></a></li>';
        }
        }
        else{
            if(!empty($getcategoryList)){
            foreach($getcategoryList as $getcategoryList)
            {
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a  id="categoryid'.$getcategoryList->id.'" class="categoryid" data-select="'.$getcategoryList->id.'"><img style="height:50px;width:50px;" src="cms_media/categoryimage/'.$getcategoryList->category_image_url.'"><br><b>'.$getcategoryList->ar_category_title.'</b></a></li>';
            }
        }
        else{
            $cms_datacategoryList .= '<li style="cursor: pointer;"><a class="active" href="#" data-select="*"><b>لا</b></a></li>';
        }
        }

       $getcategoryviaproductList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('category_id',$categoryid)->where('product_status','Active')->select('product.*', 'category.category_status')->get()->toArray();
        $cms_data['categoryviaproductList'] = array();
        if(!empty($getcategoryviaproductList)){

            $cms_data['categoryviaproductList'] = $getcategoryviaproductList;
        }
        $categoryid = Category::select('id')->where('category_status','Active')->where('id',$categoryid)->first();
       
            return response()->json(['status' => 1,'status_code' => 200,'cms_data' => $cms_data,'cms_datacategoryList' => $cms_datacategoryList, 'categoryid'=>$categoryid->id, 'user_details'=>$user_details->language]);
        
       
    }

        public function searchproduct($productkey=NULL){
        
        $user_details = User::select('language')->where('role','shop_keeper')->first();
        
if($productkey != ""){
$cms_data['categoryviaproductList'] = array();
if($user_details->language == 'en'){
       $getcategoryviaproductList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('product.en_product_title', 'LIKE', "{$productkey}%")->where('product_status','Active')->select('product.*', 'category.category_status')->get()->toArray();
       if(!empty($getcategoryviaproductList)){

            $cms_data['categoryviaproductList'] = $getcategoryviaproductList;
        }
}
else{
    $getcategoryviaproductList = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('product.ar_product_title', 'LIKE', "{$productkey}%")->where('product_status','Active')->select('product.*', 'category.category_status')->get()->toArray();
       if(!empty($getcategoryviaproductList)){

            $cms_data['categoryviaproductList'] = $getcategoryviaproductList;
        }
}
return response()->json(['status' => 1,'status_code' => 200,'cms_data' => $cms_data, 'user_details'=>$user_details->language]);
}
else{
   return Redirect::to('firstmenu/details');
}
     
            
        
       
    }

    public function product_details($productid){
        $lang = Session::has('lang') ? Session::get('lang') : 'en';
        App::setLocale($lang);
        $token = null;
        if(isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        }
        $is_login = !empty($token) ? 1 : 0;
        $user_details = User::where('role','shop_keeper')->first();
        $language = $user_details->language;
             $getproductdetails = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->where('category.category_status', 'Active')->where('product.id',$productid)->where('product_status','Active')->select('product.*', 'category.category_status', 'category.en_category_title', 'category.ar_category_title')->first();
        
        return view('front.product_details',compact('is_login','user_details','language','getproductdetails'));
    }
    
    public function changelanguage($language){

        $categoryid = User::where('role','shop_keeper')->update(['language'=>$language]);
        return response()->json(['status' => 1,'status_code' => 200]);
    }

    public function language_change($lang){
        App::setLocale($lang);
        Session::put('lang',$lang);
        if(Session::has('lang')){
            return 'true';
        }
        return 'false';
    }
}
