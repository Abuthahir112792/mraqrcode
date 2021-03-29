<?php

namespace App\Exports;

use App\Orders;
use Maatwebsite\Excel\Concerns\FromArray;

class OrdersExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
    	$data= Orders::leftjoin('users', 'users.id', '=', 'orders.user_id')->where('order_status', '!=', '')->whereNotNull('order_status')->whereNotIn('order_status', ['Pending','Accepted'])->select('orders.*', 'users.mobile_number', 'users.address')->orderBy('orders.id', 'desc')->get();
     $order_array[] = array('Order Date', 'Order Id', 'User Name', 'Price', 'Status', 'Phone', 'Self Pickup', 'Address');
     foreach($data as $orderhistory)
     {
      $order_array[] = array(
       'Order Date'  => date('d-m-Y H:i', strtotime($orderhistory->created_at)),
       'Order Id'   => $orderhistory->order_id,
       'User Name'    => $orderhistory->user_name,
       'Price'  => $orderhistory->order_price,
       'Status'  => $orderhistory->order_status,
       'Phone'  => $orderhistory->mobile_number,
       'Self Pickup'   => $orderhistory->self_pickup,
       'Address'   => $orderhistory->address
      );
     }
        //return $order_array;
    return $order_array;
    }
}