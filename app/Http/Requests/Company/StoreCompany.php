<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

use App\User;
use App\Models\Company;

class StoreCompany extends FormRequest
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
            'status_id'     => 'required',
            'plan_id'       => 'required',
            'name'          => 'required|min:3|max:140',
            'email'         => 'required|email',
            'phone'         => 'nullable|telefone_com_ddd',
            'cellphone'     => 'required|celular_com_ddd',
            'document'      => 'required|cnpj|formato_cnpj',            
            'responsable'   => 'required|min:3|max:140',
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
                if ($user && ($user->company_id != $this->input('id'))) {
                    return $validator->errors()->add('email', 'Existe uma conta de usuário para o e-mail informado.');
                }

                $company = Company::where('email', $this->input('email'))->first();
                if ($company && ($company->id != $this->input('id'))) {
                    return $validator->errors()->add('email', 'Existe uma conta de usuário para o e-mail informado.');
                }

                $company = Company::where('document', preg_replace('/[^0-9]/', '', $this->input('document')))->first();
                if ($company && ($company->id != $this->input('id'))) {
                    return $validator->errors()->add('document', 'Existe um cliente com o CNPJ informado.');
                }
            } else {
                if (Company::where('email', $this->input('email'))->count() > 0) {
                    return $validator->errors()->add('email', 'existe uma empresa com o e-mail informado.');
                }
                if (User::where('email', $this->input('email'))->count() > 0) {
                    return $validator->errors()->add('email', 'existe uma conta de usuário para o e-mail informado.');
                }
                if (Company::where('document', preg_replace('/[^0-9]/', '', $this->input('document')))->count() > 0) {
                    return $validator->errors()->add('document', ' existe uma empresa com o CNPJ informado.');
                }
            }                       
        });
    }    
}
