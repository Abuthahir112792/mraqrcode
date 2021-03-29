<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Category;
use App\Product;
use App\Menu;
use Session;
use File;
use DB;

class CategoryController extends Controller
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
    public function categoryListView()
    {   
        
        return view('admin.user.category_list');
    }

    public function getCategorylist(){
        $data = [];
        $getCategory = Category::leftjoin('menu', 'menu.id', '=', 'category.menu_id')->select('category.*', 'menu.en_menu_title', 'menu.ar_menu_title', 'menu.menu_status')->get()->toArray();
        
        if(count($getCategory) > 0){
            foreach ($getCategory as $category) {
                $date_time = date('d-m-Y H:i', strtotime($category['created_at']));
                $data[] = [$category['id'],$date_time, $category['category_image_url'], $category['en_category_title'], $category['ar_category_title'], $category['en_menu_title']."-".$category['ar_menu_title'], $category['category_status']."-".$category['id'], Helper::encrypt($category['id'])];
            }
        }

        return response()->json($data);
    }

    public function addCategoryUpdate(Request $request){
        $id = Helper::decrypt($request->category_update_id);
        $file = $_FILES['menuuploadFile'];
        if($request->menu_id == ""){
            $msg = 'Please enter menu name.';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->en_category_title == ""){
            $msg = 'Please Category Name (English).';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->ar_category_title == ""){
            $msg = 'Please enter Category Name (Arabic).';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->category_image_url == ""){
            $msg = 'Please Choose Image.';
            return Redirect::back()->with('message',$msg);
        }
        else if($file['size'] > 1048576*2){
                $msg = "Upload is larger than the permitted size (2MB).";
                return Redirect::back()->with('message',$msg);
            }
        else{
            
        if($id == ''){
            
            if($request->hasFile('menuuploadFile'))
            {
                $allowedfileExtension=['jpeg','jpg','png','gif'];
                $image = $request->file('menuuploadFile');
                $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);

                if($check)
                {
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('cms_media').'/categoryimage', $name);
                    $newCategory = new Category();
                    $newCategory->menu_id = $request->menu_id;
                    $newCategory->en_category_title = $request->en_category_title;
                    $newCategory->ar_category_title = $request->ar_category_title;
                    $newCategory->category_image_url = $name;
                    $newCategory->category_status = $request->category_status;
                    $newCategory->save();
                    $msg = 'Category Added successfully.';
                        
                }else{
                    $msg = "File must be a image and it's should be jpeg,jpg,png,gif.";
                }
            }             
        }
        else{
            if($request->hasFile('menuuploadFile'))
            {
                
                $allowedfileExtension=['jpeg','jpg','png','gif'];
                $image = $request->file('menuuploadFile');
                $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);

                if($check)
                {   
                    $mediaPath = Category::select('category_image_url')->where('id', $id)->first();
                    $type = 'categoryimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->category_image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('cms_media').'/categoryimage', $name);
                    Category::where('id',$id)->update(["menu_id"=>$request->menu_id,"en_category_title"=>$request->en_category_title,"ar_category_title"=>$request->ar_category_title,"category_image_url"=>$name,"category_status"=>$request->category_status]);
                    $msg = 'Category Updated successfully.';
                        
                }else{
                    $msg = "File must be a image and it's should be jpeg,jpg,png,gif.";
                }
            }   
            else{
             Category::where('id',$id)->update(["menu_id"=>$request->menu_id,"en_category_title"=>$request->en_category_title,"ar_category_title"=>$request->ar_category_title,"category_image_url"=>$request->category_image_url,"category_status"=>$request->category_status]);
             $msg = 'Category Updated successfully.';
        }
    }
        return Redirect::back()->with('message',$msg);
    }
        return Redirect::back()->with('error','Something wrong to update Category.');
    }

    public function categoryStatuscheck($id,$status){
        Category::where('id', $id)->update(["category_status"=>$status]);
        Product::where('category_id', $id)->update(["product_status"=>$status]);
        $msg = 'Category is Inactive Successfully.';
        if($status == "Active"){
            $msg = 'Category is Active Successfully';
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
    }

    public function getcategorymenuDetail(){
        $categorymenu = Menu::all();
        
        $output = '<option value="">Select</option>';
     foreach($categorymenu as $menu)
     {
      $output .= '<option value="'.$menu->id.'">'.$menu->en_menu_title."-".$menu->ar_menu_title.'</option>';
     }
     echo $output;
    }

    public function deleteCategory($id)
    {   
        $categoryid = Helper::decrypt($id);
        $categorymediaPath = Category::select('category_image_url')->where('id', $categoryid)->first();
        $type = 'categoryimage';
                    $filePath = public_path("cms_media/{$type}/{$categorymediaPath->category_image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('category')->where('id', $categoryid)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
        
        $productidllist = Product::where('category_id', $categoryid)->get()->toArray();

        foreach ($productidllist as $value) {
            $mediaPath = Product::select('product_image_url')->where('id', $value['id'])->first();
                    $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->product_image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::table('product')->where('id', $value['id'])->delete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
        }
               
            $msg = "Category deleted successfully.";
            Session::flash('message', $msg);
            $data = [];
            return response()->json($data);
    }

    public function getCategoryDetails($id){
        return Helper::getCategoryAllDetails($id);
    }
}
