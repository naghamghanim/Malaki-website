<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MainCategory\CreateRequest;
use App\Http\Requests\MainCategory\EditRequest;
use App\Models\MainCategory;
use Session;

class MainCategoryController extends Controller
{
    function index(Request $request){

        $q=$request->q;

         $status=$request->status;
         $items=MainCategory::whereRaw("true");

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
             $items->whereRaw('(name like ? )',["%$q%"]);
         }
         
        
       // dd($active);
        
         $items=$items->paginate(10)
         ->appends([
             'q'=>$q,
             'status'=>$status
         ]);
 

       // $items=Category::Paginate(10);
       // dd($items);
        return view("admin.main-category.index")->with("items",$items);
    }
    function create(){
      //  dd("fddfdsfsd");
        return view("admin.main-category.create");
    }
    
    public function store(CreateRequest $request)
    {
        $data=$request->all();
      // dd($data);

       MainCategory::create($data);
        Session::flash("msg","تم اضافة التصنيف بنجاح");
  
         return redirect (route("main-category.index"));
    }

    public function destroy($id)
    {
        $item= MainCategory::find($id);
        $item->delete();
        Session::flash("msg","تم حذف التصنيف بنجاح");
        return redirect (route("main-category.index"));
    }


    public function edit($id)
    {
      $item= MainCategory::find($id);
        if(!$item)
        {
            session()->flash("msg","Invalid ID");
            return redirect(route("main-category.index"));

        }
        return view("admin.main-category.edit",compact('item'));
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
  
          $item=MainCategory::find($id);
          $data=$request->all();
         // dd($data);
        
          if($request['status']==1){
            $data['status']=1;
          }
          else{
            $data['status']=0;
          }
         // $data['active']=isset($request['active'])?1:0;
          // dd($data);
          $item->update($data);
  
         Session::flash("msg"," تم التعديل بنجاح");
  
          return redirect (route("main-category.index"));
    }

    public function show($id)
    {
      
       $item= MainCategory::find($id);
      // dd($item);
        if(!$item)
        {
            session()->flash("msg","Invalid ID");
            return redirect(route("main-category.index"));
        }

        return view("admin.main-category.show",compact('item'));
    }
}

