<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Menu;
use App\Category;
use App\Product;
use Auth;
use Session;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        /*$date = date("Y-m-d");
        
        $user = User::where('role','user')->get();
        $data['usercount'] = count($user);*/
        
        $activemenu = Menu::where('menu_status','Active')->get();
        $data['activemenu'] = count($activemenu);
        
        $activecategory = Category::where('category_status','Active')->get();
        $data['activecategory'] = count($activecategory);

        $activeproduct = Product::where('product_status','Active')->get();
        $data['activeproduct'] = count($activeproduct);
        
        /*$total_amount = Orders::where('order_status','Completed')->whereDate('created_at', '=' ,$date)->sum('order_price');
        $data['total_amount'] = $total_amount;*/

        /*$top_users = User::leftjoin('orders', 'orders.user_id', '=', 'users.id')->select('users.*', 'orders.user_id', DB::raw('count(*) as total'))->orderBy('total', 'DESC')->groupBy('orders.user_id')->skip(0)->take(10)->get();*/
        
        //return view('home', ['data' => $data, 'top_users' => $top_users]);
        return view('home', ['data' => $data]);
       
    }

    public function orderAllow($status){
        User::where('id', Auth::user()->id)->orWhere('role','shop_keeper')->update(["order_allow"=>$status]);
        $msg = 'Shop Closed Successfully.';
        if($status == 1){
            $msg = 'Shop Opened Successfully.';
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
    }

    /*public function userchart(){
        $year = date("Y");
        $order_status = "Completed";
        $userchartmonthdata = [];
        $userchartcountdata = [];

        $userchartmonth =  Orders::select(DB::raw('MONTHNAME(created_at) AS m'))->where('order_status', '=', $order_status)->whereYear('created_at', '=', $year)->groupBy('m')->get()->toArray();

        $userchartcount =  Orders::select(DB::raw('COUNT(DISTINCT user_id) AS usercount'))->where('order_status', '=', $order_status)->whereYear('created_at', '=', $year)->groupBy(DB::raw("Month(created_at)"))->get()->toArray();

        foreach ($userchartmonth as $userchartmonth) {
                $userchartmonthdata[] = [$userchartmonth['m']];
            }
        
        foreach ($userchartcount as $userchartcount) {
                $userchartcountdata[] = [$userchartcount['usercount']];
            }
        
        return response()->json(['status' => 'Success!','status_code' => 200,'month' => $userchartmonthdata,'count' => $userchartcountdata]);
    }*/

    /*public function getSalesDetails($saleshistory){
        $date = date("Y-m-d");
        $month = date("m");
        if($saleshistory == "today_sale"){
              $today_amount = Orders::where('order_status','Completed')->whereDate('created_at', '=' ,$date)->sum('order_price');
              $data = $today_amount;
        }else{
              $total_amount = Orders::where('order_status','Completed')->whereMonth('created_at', '=' ,$month)->sum('order_price');
              $data = $total_amount;
        }
        

        return response()->json(['status' => 'Success!','status_code' => 200,'data' => $data]);
    }*/

    
}
