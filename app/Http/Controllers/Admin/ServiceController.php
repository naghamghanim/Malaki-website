<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\Service;
use App\Http\Requests\Service\CreateRequest;
use App\Http\Requests\Service\EditRequest;


class ServiceController extends Controller
{
    public function index(Request $request)
    {

        $items =Service::all();
        $q = $request->q;
        $active = $request->active;
        $query = Service::where('id','>',0);
        if($active!=''){
            $query->where('active',$active);
        }
       
        if($q){
            $query->whereRaw('(title like ? or slug like ?)',["%$q%","%$q%"]);
        }

        $items = $query->paginate(3)
        ->appends([
            'q'     =>$q,
            'active'=>$active
            ]);
        return view("admin.service.index",compact('items'));
    }
//--------------------------------------------
    public function create()
    {
        return view("admin.service.create");
    }
//------------------------------------------------------------------
    public function store(CreateRequest $request)
    {
        if(!isset($request['active'])){
            $request['active'] = 0;
        }

        $requestData = $request->all(); 
        if($request->image){
            $fileName = $request->image->store("public/images");
            $imageName = $request->image->hashName();
            $requestData['image'] = $imageName;
        }
        Service::create($requestData);
        Session::flash("msg","s:تمت عملية الإضافة بنجاح ");
        return redirect(route("service.index"));
    }
    //-----------------------------------------------------------
    public function show($id)
    {
       $item = Service::find($id);
        if(!$item){
            session()->flash("msg","w:غير فعّال ");
            return redirect(route("service.index"));
        }
        return view("admin.service.show",compact('item'));
    }
    //---------------------------------------------------------------
    public function edit($id)
    {
        $item = Service::find($id);
        if(!$item){
            session()->flash("msg","e:غير فعّال ");
            return redirect(route("service.index"));
        }
         return view("admin.service.edit")->with('item',$item);
    }
//--------------------------------------------------------------------
public function update(EditRequest $request, $id)
{
    $itemDB = Service::find($id);        
    $requestData = $request->all();
    if($request->image){
        $fileName = $request->image->store("public/images");
        $imageName = $request->image->hashName();
        $requestData['image'] = $imageName;
    }
    $itemDB->update($requestData);

    session()->flash("msg","s:تم التعديل بنجاح ");
    return redirect(route("service.index"));
}
//--------------------------------------------------------------------
public function destroy($id)
{
    $itemDB = Service::find($id);
    $itemDB->delete();
    session()->flash("msg","w:تم حذف الخدمة ");
    return redirect(route("service.index"));
}
}
