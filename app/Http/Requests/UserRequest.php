<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'level' => 'required',
            'regional_id' => 'required',
            'branch_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'harus diisi',
            'username.required' => 'harus diisi',
            'username.unique' => 'username sudah digunakan',
            'email.required' => 'harus diisi',
            'email.unique' => 'email sudah digunakan',
            'level.required' => 'harus diisi',
            'regional_id.required' => 'harus diisi',
            'branch_id.required' => 'harus diisi',
        ];
    }
}
