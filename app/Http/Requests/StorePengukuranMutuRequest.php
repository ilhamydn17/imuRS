<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengukuranMutuRequest extends FormRequest
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
            'numerator' => 'required|numeric|max:100',
            'denumerator' => 'required|numeric|max:100',
            'tanggal_input' => 'required|date',
        ];
    }

    // error message
    public function messages(): array
    {
        return [
            'numerator.required' => 'Numerator tidak boleh kosong',
            'numerator.numeric' => 'Numerator harus berupa angka',
            'numerator.max' => 'Numerator tidak boleh lebih dari 100',
            'denumerator.required' => 'Denumerator tidak boleh kosong',
            'denumerator.numeric' => 'Denumerator harus berupa angka',
            'denumerator.max' => 'Denumerator tidak boleh lebih dari 100',
        ];
    }
}
