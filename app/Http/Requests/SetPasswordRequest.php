<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetPasswordRequest extends FormRequest
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
            'username' => 'required',
            'password' => 'required|min:8',
            're_password' => 'required|same:password|min:8',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'username tidak boleh kosong',
            'password.required' => 'harus diisi',
            'password.min' => 'minimal 8 karakter',
            're_password.required' => 'harus diisi',
            're_password.same' => 'password tidak sama',
            're_password.min' => 'minimal 8 karakter',
        ];
    }
}
