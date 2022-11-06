<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\EditRequest;
use Spatie\Permission\Models\Role;
use Session;

class CustomerDetailsController extends Controller
{

    public function index(Request $request)
    {
        //encrypt + decrypt
        //encrypt('1');
        //decrypt('nkjnbkj nbzcjm rsad;')
        $q = $request->q;
        $adminRole = Role::findByName('customer');
        //dd($adminRole);
        $items = $adminRole->users()->whereRaw('(email like ? or name like ?)',["%$q%","%$q%"])
            ->paginate(10)
            ->appends(['q'=>$q]);

        return view("admin.customer-details.index")->with('items',$items);
    }

    public function create()
    {


       // return view("admin.customer-details.create");
    }

    public function store(CreateRequest $request)
    {
      /*  $requestData = $request->all();
        $requestData['password'] = bcrypt($requestData['password']);
        $user = User::create($requestData);        
        $user->assignRole('customer');
        Session::flash("msg","s: تمت عملية الاضافة بنجاح");
        return redirect(route("customer-details.create"));*/
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $item = User::find($id);
        if(!$item){
            session()->flash("msg","e:عنوان المستخدم غير صحيح");
            return redirect(route("customer-details.index"));
        }
        return view("admin.customer-details.edit",compact('item'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
       // dd($request->all());
        $requestData = $request->all();
       // dd($requestData);
       /* if($request['status']==1){
            $requestData['status']=1;
          }
          else{
            $requestData['status']=0;
          }*/
        $user->update($requestData);

        session()->flash("msg","s:تم تعديل بيانات المستخدم بنجاح");
        return redirect(route("customer-details.index"));
    }


    public function destroy($id)
    {
        $itemDB = User::find($id);
        $itemDB->delete();
        session()->flash("msg","w:تم حذف المستخدم بنجاح");
        return redirect(route("customer-details.index"));
    }
}
