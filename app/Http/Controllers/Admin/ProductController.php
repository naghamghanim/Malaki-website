<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\EditRequest;
use Illuminate\Support\Str;

class ProductController extends Controller
{
   public function index(Request $request)
        {
            $q = $request->q;
            $category = $request->category;
            $status = $request->status;
    
            $query = Product::leftJoin('product_categories','product_category_id','product_categories.id')->whereRaw('true');
            
            if($status!=''){
                $query->where('status',$status);
            }
    
            if($category){
                $query->where('product_category_id',$category);
            }
            
            if($q){
                $query->whereRaw('(products.name like ? or product_categories.name  like ? or slug like ?)',["%$q%","%$q%","%$q%"]);
            }
    
            
            $products = $query->select('products.*')->paginate(8)
            ->appends([
                'q'     =>$q,
                'category'=>$category,
                'status'=>$status
            ]);
    
            $categories = ProductCategory::all();
            return view("admin.product.index",compact('products','categories')); 
            
           
        }
         /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = product::all();
        $categories = category::all();
        $product_categories=ProductCategory::all();

        return view("admin.product.create",compact('products','categories','product_categories'));
        
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        // store the image
        $fileName = $request->img->store("public/assets/img"); 
        //change the name of image to store in DB
        $imageName = $request->img->hashName();
        
        //get the data
        $requestData = $request->all();
        
        $requestData['img'] = $imageName;
      
        // $name=$requestData['name'];
        // $product_category_id=$requestData['product_category_id'];
      
        // $product_categories=Product::where('name',$name)
        //             ->where('product_category_id',$product_category_id)
        //             ->get()->toArray();
        //             //dd($product_categories);
        //             if(!$product_categories)
        //             {
        //               Product::create($requestData);
        //               Session::flash("msg","تم اضافة التصنيف بنجاح");
                
        //                return redirect (route("product.index"));
        //             }
        //             else{
        //               Session::flash("msg"," اسم التصنيف موجود ... اختر اسم وتصنيف اخر");
        //                return redirect (route("product.create"));
      
        //             }
        
        Product::create($requestData);
        Session::flash("msg","s: تمت الإضافة بنجاح");
        return redirect(route("product.index"));        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $categories = category::all();
        $product_categories=ProductCategory::all();
        if(!$product){
            session()->flash("msg","w: العنوان غير صحيح");
            return redirect(route("products.index"));
        }
        return view("admin.product.show",compact('product','categories','product_categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = category::all();
        $product_categories=ProductCategory::all();
        if(!$product){
            session()->flash("msg","e:العنوان غير صحيح");
            return redirect(route("products.index"));
        }
        
        $categories = category::all();
        return view("admin.product.edit",compact('product','categories','product_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRequest $request, $id)
    {
        $productDB = Product::find($id);
        $request['slug'] = Str::slug($request['name']);
      //  $request['images'] = "2";
        if($request['img']){            
            $requestData = $request->all();
            $fileName = $request->main_image->store("public/assets/img");
            $imageName = $request->main_image->hashName();
            $requestData['img'] = $imageName;            
            $productDB->update($requestData);
        }
        else{
            
            Product::where('id', $id)->update(array('name' => $request['name'],
                                                     'quantity'=> $request['quantity'],
                                                     'product_category_id'=> $request['product_category_id'],
                                                     'regular_price'=> $request['regular_price'],
                                                     'discount'=> $request['discount'],
                                                     'details'=> $request['details'],
                                                     'slug'=> $request['slug'],
                                                     'status'=> $request['status'],
                                                     'age'=> $request['age']
                                                    ));
        }
        
        
        session()->flash("msg","s:تم تعديل المنتج بنجاح");
        return redirect(route("product.index"));

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("products")->where("id",$id)->delete();
        session()->flash("msg","w:تم حذف المنتج بنجاح");
        return redirect(route("product.index"));
    }
        
}
