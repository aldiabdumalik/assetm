<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArrivalRequest extends FormRequest
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
            'branch_id' => 'required',
            'regional_desc' => 'required',
            'branch_desc' => 'required',
            'delivery_pic' => 'required',
            'user_pic' => 'required',
            'arrival_date' => 'required',
            'arrival_total' => 'required',
            'arrival_note' => 'max:100',
        ];
    }

    public function messages()
    {
        return [
            'branch_id.required' => 'harus diisi',
            'regional_desc.required' => 'harus diisi',
            'branch_desc.required' => 'harus diisi',
            'delivery_pic.required' => 'harus diisi',
            'user_pic.required' => 'harus diisi',
            'arrival_date.required' => 'harus diisi',
            'arrival_total.required' => 'harus diisi',
            'arrival_note.max' => 'maksimal karakter 100',
        ];
    }
}
