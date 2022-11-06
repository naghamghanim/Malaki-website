<?php

namespace App\Http\Requests\ProductCategory;
use App\Models\ProductCategory;
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
        $id = $this->route('product_category');
        //dd($id);
        $categories=ProductCategory::where('id',$id)->get()->toArray();
        $cat_id=$categories[0]['category_id'];
       // dd($cat_id);
        return [
            'name'=>'required|unique:product_categories,name,' . $cat_id . ',category_id'
        ];
    }
}
