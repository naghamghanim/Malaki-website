<?php

namespace App\Http\Requests\MainCategory;

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
        $id = $this->route('main-category');
      //  dd($id);
        return [
            'name'=>'required|unique:main_categories,name,' . $id . ',id'
        ];
    }
}
