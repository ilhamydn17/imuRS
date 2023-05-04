<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndikatorMutuRequest extends FormRequest
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
            //valdate inputan form tambah indikator mutu
            'unit_id' => 'required|integer',
            'nama_indikator' => 'required|string|max:255',
            'nama_numerator'=> 'required|string|max:255',
            'nama_denumerator'=> 'required|string|max:255',
        ];
    }
}
