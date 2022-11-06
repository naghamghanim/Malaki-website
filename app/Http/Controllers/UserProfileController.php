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
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

use DB;
class UserProfileController extends Controller
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

        $items = Customer::join("users","user_id","=","users.id")
        ->where('email','like',"%$q%")
        ->orWhere('name','like',"%$q%")
        ->select("customers.*","users.name","users.email")
        ->paginate(10)
        ->appends(['q'=>$q]);

        return view("member.user-profile.index",compact('homeSliders','main_categories','categories','product_categories','products','items'));
    }

   

    public function update(Request $request){
       
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
        $id=auth()->user()->id;
        $data=$request->all();

        $name=$data['name'];
        $email=$data['email'];
        $phone=$data['phone'];
        $mobile=$data['mobile'];
        $address=$data['address'];

        if($request['image']){           
           // dd($request->file('image'));
            $fileName =$request->image->store('public/assets/users_images');
            $imageName = $request->image->hashName();
            $requestData['image'] = $imageName;            
            $image=$requestData['image'];
            DB::table('users')
            ->where('id', $id)
            ->update(['image' => $image]);
        }

        DB::table('users')
              ->where('id', $id)
              ->update(['email' => $email, 'name' => $name]);

              DB::table('customers')
              ->where('user_id', $id)
              ->update(['address' => $address, 'phone' => $phone, 'mobile'=>$mobile]);

              $user=User::find($id);
              $userDetails=Customer::where('user_id', $id)->get();
        
              return view("home.member.user-profile",compact('main_categories','categories','product_categories','user','userDetails'));
            }

    function show(Request $request)
    {
      
        $main_categories=MainCategory::where('status','1')->get();
        $categories=Category::where('status','1')->get();
        $product_categories=ProductCategory::where('status','1')->get();
      
       // here we have to get the data of user
       $id=auth()->user()->id;
       
       // we have to get the name , email, and information from customers table using the id

       $user=User::find($id);
       $userDetails=Customer::where('user_id', $id)->get();

  
      //  dd($user);
        return view("home.member.user-profile",compact('main_categories','categories','product_categories','user','userDetails'));
  
    }

}