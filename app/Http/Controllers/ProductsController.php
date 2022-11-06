<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\MainCategory;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\Product;

use DB;


class ProductsController extends Controller
{
    function index(){
       
    }

    function product_category($id,Request $request)
    {
      $q=$request->q;
      $age=$request->age;
      $category_id=$request->category_id;

      if(isset($q))
      {
      $query= Product::whereRaw('true');
      }
      else
      {
      $query= Product::whereRaw('(product_category_id = ? )',["$id"]);
      }
      
     /* if($age)
      {
        $query->whereRaw('(age = ?)',["%$age%"]);
      }*/

       if($q){
                $query->whereRaw('(name like ? or slug like ?)',["%$q%","%$q%"]);
            }

        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
       // $products= Product::whereRaw('(product_category_id = ? )',["$id"])->get();
      //  $products = DB::table('products')->where('product_category_id', ["$id"])->get();
      //  dd($products);
      $products = $query->paginate(8)
      ->appends([
                'q'     =>$q,
                'age'=>$age,
                'category_id'=>$category_id
            ]);

        return view("home.products",compact('products','main_categories','categories','product_categories'));

    }


    function productDetails($id)
    { $main_categories=MainCategory::where('status','1')->get();
      $categories=Category::where('status','1')->get();
      $product_categories=ProductCategory::where('status','1')->get();
      $product = Product::find($id);
      $product_category=$product->product_category_id;
    
      $products = Product::where('product_category_id',["$product_category"])->orderBy('id','desc')->take(4)->get();
     // dd($products);


      return view("home.product-details",compact('product','main_categories','categories','product_categories','products'));
    }

    
}