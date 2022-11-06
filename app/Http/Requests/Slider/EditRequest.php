<?php

namespace App\Http\Requests\Slider;

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
        return [
            'name'=>'required'
        ];
        //رقم المستخدم المنوي التعديل عليه
      /*  $id = $this->route('slider');
        return [
            'name'=>'required|unique:sliders,name,' . $id . ',id'
        ];*/
    }
}
