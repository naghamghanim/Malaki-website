<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\EditRequest;
use App\Models\Category;
use App\Models\MainCategory;
use Session;

class CategoryController extends Controller
{
    function index(Request $request){

         $q=$request->q;
        $main_category=$request->main_category;
         $status=$request->status;
         $items=Category::whereRaw("true");
         $categories=MainCategory::get();
         $main_item=MainCategory::whereRaw("true");
         if($status)
         {
             $items->where("status",$status);
         }
         if($status=="0")
         {
             
             $items->where("status",$status);
         }
         if($main_category)
         {
          
           $items->where('main_category_id',$main_category);
        // dd($main_cate);
         }
         if($q)
         {
         
             $items->whereRaw('(name like ? )',["%$q%"]);
            // dd($items);
         }
         
        
       // dd($status);
        
         $items=$items->paginate(10)
         ->appends([
             'q'=>$q,
             'status'=>$status
         ]);

       // dd($items);
        return view("admin.category.index",compact('items','categories'));
    }
    function create(){
      $categories=MainCategory::all();
    
        return view("admin.category.create")->with("categories",$categories);
    }
    
    public function store(CreateRequest $request)
    {
        $data=$request->all();
       
        Category::create($data);
        Session::flash("msg","تم اضافة التصنيف بنجاح");
  
         return redirect (route("category.index"));
    }

    public function destroy($id)
    {
        $item= Category::find($id);
        $item->delete();
        Session::flash("msg","تم حذف التصنيف بنجاح");
        return redirect (route("category.index"));
    }


    public function edit($id)
    {
      $item= Category::find($id);
      $categories=MainCategory::all();

        if(!$item)
        {
            session()->flash("msg","Invalid ID");
            return redirect(route("category.index"));

        }
        return view("admin.category.edit",compact('item','categories'));
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
  
          $item=Category::find($id);
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
  
          return redirect (route("category.index"));
    }

    public function show($id)
    {
      
       $item= Category::find($id);
      // dd($item);
        if(!$item)
        {
            session()->flash("msg","Invalid ID");
            return redirect(route("category.index"));
        }

        return view("admin.category.show",compact('item'));
    }
}

