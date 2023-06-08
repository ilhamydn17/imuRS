<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama_unit' => 'required|string|max:255',
            'code_identity' => 'required|string|max:6|unique:unit,code_identity',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_unit.required' => 'Nama unit tidak boleh kosong',
        ];
    }
}
