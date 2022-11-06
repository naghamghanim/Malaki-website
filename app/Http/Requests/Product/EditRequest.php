<?php

namespace App\Http\Requests\Product;
use App\Models\Product;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //رقم المستخدم المنوي التعديل عليه
        // $id = $this->route('product');
        // //dd($id);
        // $product_cat=Product::where('id',$id)->get()->toArray();
        // $prod_cat_id=$product_cat[0]['product_category_id'];
       // dd($cat_id);
        return [
           // 'name'=>'required|unique:products,name,' . $prod_cat_id . ',product_category_id'
           'name'=>'required|',
           'product_category_id'=>'required'
        ];
    }
}
