<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CharacterPostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'defence' => 'required|numeric|min:0|max:20',
            'strength' => 'required|numeric|min:0|max:20',
            'accuracy' => 'required|numeric|min:0|max:20',
            'magic' => 'required|numeric|min:0|max:20',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Erzsi, nincsen név!',
            'name.min' => 'Erzsi, adj :min betűt!',
            'max' => 'Ez az érték maximum :max kell legyen.',
            'min' => 'Ez az érték minimum :min lehet.',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $total = (int) $this->input('defence') + (int) $this->input('strength') + (int) $this->input('accuracy') + (int) $this->input('magic');
                if ($total > 20) {
                    $validator->errors()->add(
                        'total',
                        'Maximum 20 pontot oszthatsz ki egy karakternek!'
                    );
                }
            }
        ];
    }
}
