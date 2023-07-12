<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScanningRequest extends FormRequest
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
            'type_id' => 'required',
            'brand_id' => 'required',
            'model_id' => 'required',
            'scan_box' => 'required',
            'scan_sn' => 'required',
            'scan_mac' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'type_id.required' => 'harus diisi',
            'brand_id.required' => 'harus diisi',
            'model_id.required' => 'harus diisi',
            'scan_box.required' => 'harus diisi',
            'scan_sn.required' => 'harus diisi',
            'scan_mac.required' => 'harus diisi',
        ];
    }
}
