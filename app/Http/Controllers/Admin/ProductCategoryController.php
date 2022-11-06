<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductCategory\CreateRequest;
use App\Http\Requests\ProductCategory\EditRequest;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\ProductCategory;

use Session;

class ProductCategoryController extends Controller
{
    function index(Request $request){

        $q=$request->q;

         $status=$request->status;
         $items=ProductCategory::whereRaw("true");
         $categories=Category::all();
        
       
         if($status)
         {
             $items->where("status",$status);
         }
         if($status=="0")
         {
             
             $items->where("status",$status);
         }
         if($q)
         {
           //  dd($q);
             $items->whereRaw('(name like ? )',["%$q%"]);
         }
         
        
       // dd($status);
        
         $items=$items->paginate(10)
         ->appends([
             'q'=>$q,
             'status'=>$status
         ]);
 

       // $items=Category::Paginate(10);
       // dd($items);
        return view("admin.product_category.index",compact('items','categories'));
    }
    function create(){
      $categories=Category::all();
    
        return view("admin.product_category.create")->with("categories",$categories);
    }
    
    public function store(CreateRequest $request)
    {
        $data=$request->all();
       // dd($data);
        $name=$data['name'];
        $category_id=$data['category_id'];
      
        $categories=ProductCategory::where('name',$name)
                    ->where('category_id',$category_id)
                    ->get()->toArray();
                //    dd($categories);
                    if(!$categories)
                    {
                      ProductCategory::create($data);
                      Session::flash("msg","تم اضافة التصنيف بنجاح");
                
                       return redirect (route("product_category.index"));
                    }
                    else{
                      Session::flash("msg","w: اسم التصنيف موجود ... اختر اسم وتصنيف اخر");
                       return redirect (route("product_category.create"));
      
                    }
    }
    public function destroy($id)
    {
        $item= ProductCategory::find($id);
        $item->delete();
        Session::flash("msg","تم حذف التصنيف بنجاح");
        return redirect (route("product_category.index"));
    }
    public function edit($id)
    {
      $item= ProductCategory::find($id);
      $categories=Category::all();

        if(!$item)
        {
            session()->flash("msg","Invalid ID");
            return redirect(route("product_category.index"));
        }
        return view("admin.product_category.edit",compact('item','categories'));
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
  
          $item=ProductCategory::find($id);
          $data=$request->all();
          if($request['status']==1){
            $data['status']=1;
          }
          else{
            $data['status']=0;
          }
         // $data['status']=isset($request['status'])?1:0;
         //  dd($data);
          $item->update($data);
  
         Session::flash("msg"," تم التعديل بنجاح");
  
          return redirect (route("product_category.index"));
    }

    public function show($id)
    {
      
       $item= ProductCategory::find($id);
      // dd($item);
        if(!$item)
        {
            session()->flash("msg","Invalid ID");
            return redirect(route("category.index"));
        }

        return view("admin.category.show",compact('item'));
    }
}

