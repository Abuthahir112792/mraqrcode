<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Helpers\Helper;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Validator;
use Session;
use File;
use DB;

class ProductController extends Controller
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
    public function productListView()
    {   
        
        return view('admin.user.product_list');
    }

    public function getProductlist(){
        $data = [];
        $getProduct = Product::leftjoin('category', 'category.id', '=', 'product.category_id')->select('product.*', 'category.en_category_title', 'category.ar_category_title')->get()->toArray();
        
        if(count($getProduct) > 0){
            foreach ($getProduct as $product) {
                $date_time = date('d-m-Y H:i', strtotime($product['created_at']));
                $data[] = [$product['id'],$date_time, $product['product_image_url'], $product['en_product_title'], $product['ar_product_title'], $product['en_category_title']."-". $product['ar_category_title'], $product['en_product_price'], $product['ar_product_price'], $product['product_status']."-".$product['id'], Helper::encrypt($product['id'])];
            }
        }

        return response()->json($data);
    }

    public function addProductUpdate(Request $request){
        $id = Helper::decrypt($request->product_update_id);
        $file = $_FILES['uploadFile'];
        if($request->en_product_title == ""){
            $msg = 'Please enter Product Name (English).';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->ar_product_title == ""){
            $msg = 'Please enter Product Name (Arabic).';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->category_id == ""){
            $msg = 'Please enter category name.';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->en_product_description == ""){
            $msg = 'Please enter Product Description (English).';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->ar_product_description == ""){
            $msg = 'Please enter Product Description (Arabic).';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->en_product_price == ""){
            $msg = 'Please enter Product Price (English).';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->ar_product_price == ""){
            $msg = 'Please enter Product Price (Arabic).';
            return Redirect::back()->with('message',$msg);
        }
        else if($request->product_image_url == ""){
            $msg = 'Please Choose image.';
            return Redirect::back()->with('message',$msg);
        }
        else if($file['size'] > 1048576*2){
                $msg = "Upload is larger than the permitted size (2MB).";
                return Redirect::back()->with('message',$msg);
            }
        
        else{
            
        if($id == ''){
            
            if($request->hasFile('uploadFile'))
            {
                $allowedfileExtension=['jpeg','jpg','png','gif'];
                $image = $request->file('uploadFile');
                $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);

                if($check)
                {
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('cms_media').'/productimage', $name);
                    $newProduct = new Product();
                    $newProduct->category_id = $request->category_id;
                    $newProduct->en_product_title = $request->en_product_title;
                    $newProduct->ar_product_title = $request->ar_product_title;
                    $newProduct->en_product_description = $request->en_product_description;
                    $newProduct->ar_product_description = $request->ar_product_description;
                    $newProduct->en_product_price = $request->en_product_price;
                    $newProduct->ar_product_price = $request->ar_product_price;
                    $newProduct->product_image_url = $name;
                    $newProduct->product_status = $request->product_status;
                    $newProduct->save();
                    $msg = 'Product Added successfully.';
                        
                }else{
                    $msg = "File must be a image and it's should be jpeg,jpg,png,gif.";
                }
            }             
        }
        else{
            if($request->hasFile('uploadFile'))
            {
                
                $allowedfileExtension=['jpeg','jpg','png','gif'];
                $image = $request->file('uploadFile');
                $filename = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);
               
                if($check)
                {   
                    $mediaPath = Product::select('product_image_url')->where('id', $id)->first();
                    $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->product_image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $image->move(public_path('cms_media').'/productimage', $name);
                    Product::where('id',$id)->update(["category_id"=>$request->category_id,"en_product_title"=>$request->en_product_title,"ar_product_title"=>$request->ar_product_title,"en_product_description"=>$request->en_product_description,"ar_product_description"=>$request->ar_product_description,"en_product_price"=>$request->en_product_price,"ar_product_price"=>$request->ar_product_price,"product_image_url"=>$name,"product_status"=>$request->product_status]);
                    $msg = 'Product Updated successfully.';
                        
                }else{
                    $msg = "File must be a image and it's should be jpeg,jpg,png,gif.";
                }
            }   
            else{
             Product::where('id',$id)->update(["category_id"=>$request->category_id,"en_product_title"=>$request->en_product_title,"ar_product_title"=>$request->ar_product_title,"en_product_description"=>$request->en_product_description,"ar_product_description"=>$request->ar_product_description,"en_product_price"=>$request->en_product_price,"ar_product_price"=>$request->ar_product_price,"product_image_url"=>$request->product_image_url,"product_status"=>$request->product_status]);
             $msg = 'Product Updated successfully.';
        }
    }
        return Redirect::back()->with('message',$msg);
    }
        return Redirect::back()->with('error','Something wrong to update order.');
    }

    public function productStatuscheck($id,$status){
        Product::where('id', $id)->update(["product_status"=>$status]);
        $msg = 'Product is Inactive Successfully.';
        if($status == "Active"){
            $msg = 'Product is Active Successfully';
        }
        return response()->json(['status' => 'Success!','status_code' => 200,'msg' => $msg]);
    }

    public function getproductcategoryDetail(){
        $productcategory = Category::all();
        
        $output = '<option value="">Select</option>';
     foreach($productcategory as $category)
     {
      $output .= '<option value="'.$category->id.'">'.$category->en_category_title."-".$category->ar_category_title.'</option>';
     }
     echo $output;
    }
  
    public function deleteProduct($id)
    {   
        $productid = Helper::decrypt($id);
        $mediaPath = Product::select('product_image_url')->where('id', $productid)->first();
                    $type = 'productimage';
                    $filePath = public_path("cms_media/{$type}/{$mediaPath->product_image_url}");
                    if (File::exists($filePath)) {
                    unlink($filePath);
                    }
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                    DB::table('product')->where('id', $productid)->delete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');        
                    
        
            $msg = "Menu deleted successfully.";
            Session::flash('message', $msg);
            $data = [];
            return response()->json($data);
    }

    

    public function getProductDetails($id){
        return Helper::getProductAllDetails($id);
    }
}
