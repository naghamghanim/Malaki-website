<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\MainCategory;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;

use App\Models\Product;
use Illuminate\Http\Request;

use DB;
class OrdersController extends Controller
{
    function index(Request $request){
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
        $order_num=$request->order_num;
        $order_email=$request->order_email;
       // $items=Order::whereRaw("true");
       $items=collect([]);
      
       
        if($order_num && $order_email)
         {
            // dd($order_num);
           $items=Order::where('id', '=', $order_num)
                         ->where('email', '=', $order_email)
                         ->get();
                        

           /* $items=DB::table('orders')
                   ->where('id', '=', $order_num)
                   ->where('email', '=', $order_email)
                   ->get();*/
                 //  dd($items);
               //  $items->where("id",$order_num);
              //   $items->where("email",$order_email);
              //   $items=$items->paginate(10);       
                 foreach($items as $c){
                    $items=$c;
                  }
               
        }
       
        return view("home.check-orders",compact('main_categories','categories','product_categories','items'));


    }

 

}