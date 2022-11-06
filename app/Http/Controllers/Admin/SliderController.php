<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Slider\CreateRequest;
use App\Http\Requests\Slider\EditRequest;
use App\Models\Slider;
use Session;

class SliderController extends Controller
{
    function index(Request $request){
        $q = $request->q;
        $status = $request->status;

        $query = Slider::whereRaw('true');
        
        if($status!=''){
            $query->where('status',$status);
        }

        if($q){
            $query->whereRaw('(name like ? or slug like ?)',["%$q%","%$q%"]);
        }

        $items = $query->paginate(8)
        ->appends([
            'q'     =>$q,
            'status'=>$status
        ]);

        return view("admin.slider.index",compact('items'));         
    }
    function create(){
        return view("admin.slider.create");
    }
    
    public function store(CreateRequest $request)
    {       
        if(!isset($request['status'])){
            $request['status'] = 0;
        }
        if(!isset($request['new_window'])){
            $request['new_window'] = 0;
        }
        $requestData=$request->all();
        if($request->image){
            $fileName=$request->image->store('public/assets/slider_images');
            $imgeName=$request->image->hashName();
            $requestData['image']=$imgeName;
        }
        Slider::create($requestData);
        Session::flash("msg","Slider Created Successfully");

        return redirect(route("slider.index"));
    }

    public function show($id)
    {

        $item = Slider::find($id);
        if(!$item){
            session()->flash("msg","w:Invalid Id");
            return redirect(route("slider.index"));
        }
        return view("admin.slider.show",compact('item'));
    }
    public function edit($id)
    {
        $item=Slider::find($id);
        if(!$item){
            session()->flash("msg","Invalid Id");
            return redirect(route("slider.index"));
        }
        return view("admin.slider.edit",compact('item'));
    }
    public function update(EditRequest $request, $id)
    {
       // dd($request::all());
        $request['status'] = isset($request['status'])?1:0;
        $request['new_window'] = isset($request['new_window'])?1:0;
        $itemDB = Slider::find($id);        
        $requestData = $request->all();
        if($request->image){
            $fileName = $request->image->store("public/assets/slider_images");
            $imageName = $request->image->hashName();
            $requestData['image'] = $imageName;
        }
        $itemDB->update($requestData);
        session()->flash("msg","s:Slider Updated Successfully");
        return redirect(route("slider.index"));
    }
    public function destroy($id)
    {
        $itemDB=Slider::find($id);
        $itemDB->delete();
        session()->flash("msg","Slider Deleted Successfully");
        return redirect(route("slider.index"));
    }

}