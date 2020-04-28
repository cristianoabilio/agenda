<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlan extends FormRequest
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
            'id'            => 'nullable|numeric',
            'name'          => 'required|min:3|max:140',
            'description'         => 'required|max:150',
            'type'     => 'required',
            'price'      => 'required',            
            'validity'   => 'required|numeric',
            'quantidity'   => 'numeric',
        ];
    }
}
