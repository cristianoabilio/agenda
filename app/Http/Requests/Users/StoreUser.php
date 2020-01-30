<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class StoreUser extends FormRequest
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
            'id'       => 'nullable|numeric',
            'company_id'    => 'nullable',
            'profile_id'    => 'nullable',
            'status_id'        => 'required',
            'cellphone'        => 'required|celular_com_ddd',
            'phone'         => 'nullable|telefone_com_ddd',
            'birthday'    => 'required|data',
            'document'           => 'required|cpf|formato_cpf',
            'gender'        => 'required',
            'email'         => 'required|email',
            'name'          => 'required|min:3|max:140'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('id')) {
                $user = User::where('email', $this->input('email'))->first();
                if ($user && ($user->user_id != $this->input('user_id'))) {
                    return $validator->errors()->add('email', 'Existe uma conta de usuário para o e-mail informado.');
                }
                $user = User::where('document', preg_replace('/[^0-9]/', '', $this->input('document')))->first();
                if ($user && ($user->user_id != $this->input('user_id'))) {
                    return $validator->errors()->add('document', 'Existe um cliente com o CPF informado.');
                }
            } else {
                if (User::where('email', $this->input('email'))->count() > 0) {
                    return $validator->errors()->add('email', 'existe uma conta de usuário para o e-mail informado.');
                }
                if (User::where('document', preg_replace('/[^0-9]/', '', $this->input('document')))->count() > 0) {
                    return $validator->errors()->add('document', ' existe um cliente com o CPF informado.');
                }
            }                       
        });
    }
}
