<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UjiFungsiRequest extends FormRequest
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
            'barcode' => 'required',
            'status' => 'required',
            'box_ok' => 'required',
            'box_nok' => 'required',
            // 'type_id' => 'required',
            // 'brand_id' => 'required',
            // 'model_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'barcode.required' => 'harus diisi',
            'status.required' => 'harus diisi',
            'box_ok.required' => 'harus diisi',
            'box_nok.required' => 'harus diisi',
            // 'type_id.required' => 'harus diisi',
            // 'brand_id.required' => 'harus diisi',
            // 'model_id.required' => 'harus diisi'
        ];
    }
}
