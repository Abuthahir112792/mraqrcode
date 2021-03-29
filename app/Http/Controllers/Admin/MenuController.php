<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Menu;
use App\Category;
use App\Product;
use Session;
use DB;
use File;

class MenuController extends Controller
{   
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show Users List.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function menuListView()
    {   
        
        return view('admin.user.menu_list');
    }

    public function getMenulist(){
        $data = [];
        $getMenu = Menu::select('menu.*')->get()->toArray();
        
        if(count($getMenu) > 0){
            foreach ($getMenu as $menu) {
                $date_time = date('d-m-Y H:i', strtotime($menu['created_at']));
                $data[] = [$menu['id'],$date_time, $menu['en_menu_title'], $menu['ar_menu_title'], $menu['menu_status']."-".$menu['id'], Helper::encrypt($menu['id'])];
            }
        }

        return response()->json($data);
    }

    public function addMenuUpdate(Request $request){
        $id = Helper::decrypt($request->menu_update_id);
        if($request->en_menu_title == ""){
            $msg = 'Please enter menu english name.';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->ar_menu_title == ""){
            $msg = 'Please enter menu arabic name.';
            return Redirect::back()->with('message',$msg);
        }
        else{
        if($id == ''){
            $newMenu = new Menu();
                    $newMenu->en_menu_title = $request->en_menu_title;
                    $newMenu->ar_menu_title = $request->ar_menu_title;
                    $newMenu->menu_status = $request->menu_status;
                    $newMenu->save();
            $msg = 'New Menu Added successfully.';
            
        }
        else{
             Menu::where('id',$id)->update(["en_menu_title"=>$request->en_menu_title,"ar_menu_title"=>$request->ar_menu_title,"menu_status"=>$request->menu_status]);
             $msg = 'Menu Updated successfully.';
        }
        return Redirect::back()->with('message',$msg);
    }
        return Redirect::back()->with('error','Something wrong to update order.');
    }

    public function menuStatuscheck($id,$status){
        Menu::where('id', $id)->update(["menu_status"=>$status]);
        Category::where('menu_id', $id)->update(["category_status"=>$status]);
        $categoryidllist = Category::where('menu_id', $id)->get()->toArray();
        if(!empty($categoryidllist)){
        foreach ($categoryidllist as $categoryid) {
            $product_status = Product::where('category_id', $categoryid['id'])->update(["product_status"=>$status]);
                    
        }
    }
        $msg = 'Menu is Inactive Successfully.';
        if($status == "Active"){
            $msg = 'Menu is Active Successfully';
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
    }

    public function deleteMenu($id)
    {   
        $menuid = Helper::decrypt($id);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('menu')->where('id', $menuid)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 

       $categoryidllist = Category::where('menu_id', $menuid)->get()->toArray();
       if(!empty($categoryidllist)){
        foreach ($categoryidllist as $categoryid) {
            $productidlist = Product::where('category_id', $categoryid['id'])->get()->toArray();
            foreach ($productidlist as $productid) {
                $productimagepath = Product::where('id', $productid['id'])->first();
            $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$productimagepath->product_image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
            DB::table('product')->where('id', $productid['id'])->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
            }
            $categoryimagepath = Category::where('id', $categoryid['id'])->first();
            $type = 'categoryimage';
                    $filePath = public_path("cms_media/{$type}/{$categoryimagepath->category_image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('category')->where('id', $categoryid['id'])->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');                 
        }
    }
        
        

            $msg = "Menu deleted successfully.";
            Session::flash('message', $msg);
            $data = [];
            return response()->json($data);
    }


    public function getMenuDetails($id){
        return Helper::getMenuAllDetails($id);
    }
}
