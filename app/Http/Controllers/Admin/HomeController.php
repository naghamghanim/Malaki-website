<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(){
        $orders=Order::all();
        $order_details=OrderDetails::all();
        $total=0;
        foreach($order_details as $order_det)
        {
        $price=$order_det->price;
        $quantity=  $order_det->quantity;
        $total+=($quantity*$price);
        }
      
        $orders_num=$orders->count();
        $mytime = now();
        return view("admin.index",compact('orders_num','mytime','total'));
    }
}
