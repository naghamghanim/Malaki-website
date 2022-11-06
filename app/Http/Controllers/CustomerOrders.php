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
class CustomerOrders extends Controller
{
    function index(){
        $homeSliders = Slider::where('status','1')->orderBy('id','desc')->take(3)->get();
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
       // dd("fdgdf");
       // $more_sell=DB::select("select id,product_id, sum(quantity) as qty from order_details groupBy product_id orderBy product_id desc");
        $more_sell = DB::table('order_details')
                ->select('product_id', DB::raw('SUM(quantity) as qty'))
                ->groupBy('product_id')
                ->orderBy('product_id','desc');

        $more_sell_products = DB::table('products')
                     ->joinSub($more_sell, 'order_details', function ($join) {
                       $join->on('products.id', '=', 'order_details.product_id');
                    })->orderBy('order_details.product_id','desc')
                     ->get();

        $products=Product::where('status','1')->orderBy('id','desc')->take(4)->get();
        return view("home.member.your_orders",compact('homeSliders','main_categories','categories','product_categories','products','more_sell_products'));
    }

   

    function edit(){
       
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
        $id=auth()->user()->id;
       // dd($id);
        $customer=Order::where('customer_id',$id)->get();
        //$customer=DB::table('orders')->where('customer_id', $id)->get();
        //dd($customer);
        //dd($customer[0]->name);
        foreach($customer as $c){
          $x=$c;
        }
        //dd($x);
        return view("home.member.user-profile",compact('main_categories','categories','product_categories','x'));
    }

    function show(Request $request)
    {
      $id=auth()->user()->id;
      $email=auth()->user()->email;
    // dd($email);
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
        $order=Order::where('customer_id',$id)->get();
        $order=  DB::table('orders')
              ->where('customer_id', $id)->get();
    //   dd($order);
       // $order_num=$request->order_num;
      // $order_num=$order_num['customer_id'];
      foreach($order as $order_num)
      {
        $order_num=$order_num->id;
      }
    //  dd($order_num);
        $order_email=$email;
       // $items=Order::whereRaw("true");
       $items=collect([]);
       
        if($order_email)
         {
            // dd($order_num);
           $items=Order::where('email', '=', $order_email)
                         ->get();
                        
                        // dd($items);
           /* $items=DB::table('orders')
                   ->where('id', '=', $order_num)
                   ->where('email', '=', $order_email)
                   ->get();*/
                 //  dd($items);
               //  $items->where("id",$order_num);
              //   $items->where("email",$order_email);
              //   $items=$items->paginate(10); 
                 
                 foreach($items as $c){
                    $itemss[]=$c;
                  }
               
        }
      // dd($itemss);
       
        return view("home.member.your_orders",compact('main_categories','categories','product_categories','itemss'));
  
    }

}