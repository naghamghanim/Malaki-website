<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderStatus;
use Session;

class OrderController extends Controller
{
    function index(Request $request){
        $q = $request->q;
        $id = $request->id;
        $order_status_id = request()->order_status_id;

        $query = Order::whereRaw('true');
        
      
        if($order_status_id){
            $query->where('order_status_id',$order_status_id);
        }

        if($id){
            $query->where('id',$id);
        }

        if($q){
            $query->whereRaw('(name like ? or address like ?)',["%$q%","%$q%"]);
        }

        
        $orders = $query->orderBy('id','desc')->paginate(8)
        ->appends([
            'q'     =>$q,
            'id'     =>$id,
            'order_status_id'=>$order_status_id,
        ]);
        $detalis=OrderDetails::all();
        $status=OrderStatus::all();
        return view("admin.order.index",compact('orders','detalis','status'));         
    }

    public function show($id)
    {
        $order = Order::find($id);
       // dd($order);
        if(!$order){
            session()->flash("msg","w:Invalid Id");
            return redirect(route("order.index"));
        }
        $orderStatuses = \App\Models\OrderStatus::all();
        return view("admin.order.show",compact('order','orderStatuses'));
    }
    public function destroy($id)
    {
        $itemDB=Order::find($id);
        $itemDB->delete();
        session()->flash("msg","Slider Deleted Successfully");
        return redirect(route("order.index"));
    }
    public function updateStatus ($id, Request $request)
    {
        $status = $request->status;
        $itemDB=Order::find($id);
        if($itemDB){
            $itemDB->order_status_id = $status;
            $itemDB->save();
        }
        session()->flash("msg","s: تم تعديل حالة الطلب بنجاح");
        return redirect(asset("admin/order/$id"));
    }
 
}
