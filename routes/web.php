<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return redirect()->route('admin.login');
});
Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	Route::get('home', 'HomeController@index')->name('home');
	Route::get('order-allow/{id?}', 'HomeController@orderAllow');

//	Route::get('userchart', 'HomeController@userchart');
//
	//Route::get('sales/details/{id?}', 'HomeController@getSalesDetails');
  Route::get('user', 'Admin\UserController@usersListView')->name('user');
  Route::get('users-list', 'Admin\UserController@usersList');
    Route::post('add-user-update', 'Admin\UserController@addUserUpdate')->name('addUserUpdate');
    Route::get('user/details/{id?}', 'Admin\UserController@getuserDetails');

  Route::get('menu', 'Admin\MenuController@menuListView')->name('menu');
  Route::get('all-menu-list', 'Admin\MenuController@getMenulist');
    Route::post('add-menu-update', 'Admin\MenuController@addMenuUpdate')->name('addMenuUpdate');
    Route::get('menu/details/{id?}', 'Admin\MenuController@getMenuDetails');
    Route::get('menu-status-check/{id?}/{status?}', 'Admin\MenuController@menuStatuscheck');
    Route::get('delete/menu/{id?}', 'Admin\MenuController@deleteMenu');

	Route::get('category', 'Admin\CategoryController@categoryListView')->name('category');
	Route::get('all-category-list', 'Admin\CategoryController@getCategorylist');
   	Route::post('add-category-update', 'Admin\CategoryController@addCategoryUpdate')->name('addCategoryUpdate');
   	Route::get('category/details/{id?}', 'Admin\CategoryController@getCategoryDetails');
   	Route::get('category-status-check/{id?}/{status?}', 'Admin\CategoryController@categoryStatuscheck');
    Route::get('categorymenu/details', 'Admin\CategoryController@getcategorymenuDetail');
   	Route::get('delete/category/{id?}', 'Admin\CategoryController@deleteCategory');

	Route::get('product', 'Admin\ProductController@productListView')->name('product');
	Route::get('all-product-list', 'Admin\ProductController@getproductlist');
   	Route::post('add-product-update', 'Admin\ProductController@addProductUpdate')->name('addProductUpdate');
   	Route::get('product/details/{id?}', 'Admin\ProductController@getproductDetails');
   	Route::get('product-status-check/{id?}/{status?}', 'Admin\ProductController@productStatuscheck');
   	Route::get('productcategory/details', 'Admin\ProductController@getproductcategoryDetail');
   	Route::get('delete/product/{id?}', 'Admin\ProductController@deleteProduct');

    Route::get('orders', 'Admin\OrderController@ordersListView')->name('orders');
    Route::get('incoming-orders', 'Admin\OrderController@incomingOrders');
    Route::get('out-for-delivery', 'Admin\OrderController@outForDeliveryOrders');
    Route::get('self-pickup', 'Admin\OrderController@selfPickupOrders');
    Route::get('orderitem/details/{id?}', 'Admin\OrderController@getOrderitemDetails');
    Route::get('orderstatus/{id?}/{status?}', 'Admin\OrderController@orderStatuschange');
    Route::post('incoming-order-update', 'Admin\OrderController@incomingOrderUpdate')->name('incomingOrderUpdate');
    Route::post('out-for-order-update', 'Admin\OrderController@outForOrderUpdate')->name('outforOrderUpdate');
    Route::get('order/details/{id?}', 'Admin\OrderController@getOrderDetails');
    Route::get('neworder/{id?}', 'Admin\OrderController@neworderAllow');
    Route::get('neworderchecking', 'Admin\OrderController@neworderChecking');
    
    Route::get('editorder/{id?}', 'Admin\EditorderController@editOrderView');
    Route::get('all-orders-list/{editorderid?}', 'Admin\EditorderController@getallOrderlist');
    Route::post('all-orderdetails-update', 'Admin\EditorderController@OrderdetailsUpdate')->name('allOrderdetailsUpdate');
    Route::get('get_userorderlist_list/details/{editorderid?}', 'Admin\EditorderController@getuserorderlist');
    Route::get('updateallorderdetails/{editorderid?}/{itemid?}/{qty?}', 'Admin\EditorderController@getupdateallorderdetails');

   Route::get('history', 'Admin\HistoryController@historyListView')->name('history');
   Route::get('historyorderitem/details/{id?}', 'Admin\HistoryController@getHistoryorderitemDetails');
   Route::get('pagination/fetch_data', 'Admin\HistoryController@fetch_data');
  Route::get('/export_excel/excel', 'Admin\HistoryController@orderexcel')->name('export_excel.excel');
    Route::get('/history_list', 'HistoryController@index');

  Route::get('/history_list/fetch_data', 'HistoryController@fetch_data');
  

  //Route::get('delete/user/{id}', 'Admin\UserController@deleteUser');
    

    
});

Route::get('/', function () {
    return redirect()->route('front.home');
});
Route::namespace('Front')->group(function(){
    
    Route::get('home','HomeController@index')->name('front.home');
    Route::get('firstmenu/details','HomeController@firstmenu');
    Route::get('menuwise/details/{id?}','HomeController@menuwise');
    Route::get('product-details/{productid}','HomeController@product_details')->name('front.product.details');
	  Route::get('categorywise/details/{categoryid?}','HomeController@categorywise');
    Route::get('changelanguage/{language?}','HomeController@changelanguage');
    Route::get('searchproduct/{productkey?}','HomeController@searchproduct');
    Route::get('cartview','CartController@cartview');
    Route::get('cartproduct/details/{storage?}','CartController@getcartproduct');
  Route::get('test',function (){
        return view('test');
    });
    
});


