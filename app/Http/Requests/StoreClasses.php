<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClasses extends FormRequest
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
            'teacher_id'     => 'required',
            'modality_id'       => 'required',
            'level_id'          => 'required',
            'item'         => 'required',
            'start'         => 'required',
            'end'     => 'required',
            'description'      => 'nullable||max:140',            
        ];
    }
}
