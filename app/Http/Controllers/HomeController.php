<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\MainCategory;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;

use DB;
class HomeController extends Controller
{
    function index(){
        $homeSliders = Slider::where('status','1')->orderBy('id','desc')->take(3)->get();
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
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
        return view("home.index",compact('homeSliders','main_categories','categories','product_categories','products','more_sell_products'));
    }

    function products()
    {
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
        return view("home.products",compact('main_categories','categories','product_categories'));
    }

    function productDetails()
    {
        return view("home.product-details");
    }

    function cart()
    {   
        return view("home.cart");
    }

    function contactUS()
    {
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
       
        return view("home.contact-us",compact('main_categories','categories','product_categories'));
    }

    function aboutUS()
    {
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
       
        return view("home.about-us",compact('main_categories','categories','product_categories'));
    }

    function return()
    {
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
       
        return view("home.return",compact('main_categories','categories','product_categories'));
    }
   
}