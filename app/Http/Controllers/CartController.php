<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Models\Slider;
use App\Models\MainCategory;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetails;


use DB;

use Illuminate\Http\Request;

class CartController extends Controller
{
    function index(){
       
    }

    function cart()
    {
      // just to view the cart page
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();

        return view("home.cart",compact('main_categories','categories','product_categories'));

    }


    public function postCart(Request $request)
    {
        if($request->refresh){
            $cartItems = [];
            for($i=0;$i<count($request->id);$i++){
                $productId = $request->id[$i];
                $quantity = $request->quantity[$i];
                $cartItems[$productId] = $quantity;
            }
            $cartItemsJsonString = json_encode($cartItems);
            Cookie::queue('cart', $cartItemsJsonString, 60*24*14);
            return back();
        }
        else{
            if(!auth()->check()){
                return redirect('login');
            }
            else{
                $totalPrice = 0;
                for($i=0;$i<count($request->id);$i++){
                    $productId = $request->id[$i];
                    $quantity = $request->quantity[$i];
                    $product=Product::find($productId);
                    $totalPrice+=($product->discount??$product->regular_price)*$quantity;
                }
                $user = auth()->user();
              //  dd($user->id);
                $order = Order::create([
                    'customer_id'=>$user->id,
                    'order_status_id'=>1,
                    'total_price'=>$totalPrice,
                    'total_items'=>count($request->id),
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'phone'=>$user->customer->phone??'',
                    'mobile'=>$user->customer->mobile??'',
                    //'country_id'=>$user->customer->country_id??'',
                    'country_id'=>1,
                    'city'=>$user->customer->city??'',
                    'address'=>$user->customer->address??''
                ]);
                for($i=0;$i<count($request->id);$i++){
                    $productId = $request->id[$i];
                    $quantity = $request->quantity[$i];
                    $product = Product::find($productId);
                    $price = ($product->discount??$product->regular_price);
                    $total = $price * $quantity;
                    OrderDetails::create([
                        'order_id'=>$order->id,
                        'product_id'=>$productId,
                        'price'=>$price,
                        'quantity'=>$quantity,
                        'total_price'=>$total,
                    ]);
                }
                Cookie::queue('cart', '', 60*24*14);
                session()->flash('msg','s: تمت اضافة الطلبية بنجاح سيتم التواصل معك');
                return redirect('cart');
            }
        }
    } 

    public function addToCart($id)
    {
        $cartItems = json_decode(request()->cookie('cart'),true)??[];
       // dd($cartItems);
        if(isset($cartItems[$id]))
            $cartItems[$id] += 1;
        else
            $cartItems[$id] = 1;
        $cartItemsJsonString = json_encode($cartItems);
        Cookie::queue('cart', $cartItemsJsonString, 60*24*14);

        return back();
    }

    public function removeFromCart($id)
    {
        $cartItems = json_decode(request()->cookie('cart'),true)??[];
        unset($cartItems[$id]);
        $cartItemsJsonString = json_encode($cartItems);
        Cookie::queue('cart', $cartItemsJsonString, 60*24*14);
        return back();
    }
    
}
