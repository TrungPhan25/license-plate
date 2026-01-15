<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViolationRequest extends FormRequest
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
            'violation_date' => ['required', 'date', 'before_or_equal:today'],
            'license_plate' => [
                'required', 
                'string', 
                'max:20',
                'regex:/^\d{2}[A-Z]-\d{3,4}(\.\d{2})?$/'
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'birth_year' => [
                'required', 
                'integer', 
                'min:1900', 
                'max:' . date('Y')
            ],
            'address' => ['required', 'string'],
            'violation_type' => ['required', 'string'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'violation_date.required' => 'Ng\u00e0y vi ph\u1ea1m l\u00e0 b\u1eaft bu\u1ed9c.',
            'violation_date.date' => 'Ng\u00e0y vi ph\u1ea1m kh\u00f4ng \u0111\u00fang \u0111\u1ecbnh d\u1ea1ng.',
            'violation_date.before_or_equal' => 'Ng\u00e0y vi ph\u1ea1m kh\u00f4ng th\u1ec3 l\u00e0 ng\u00e0y trong t\u01b0\u01a1ng lai.',
            'license_plate.required' => 'Bi\u1ec3n s\u1ed1 xe l\u00e0 b\u1eaft bu\u1ed9c.',
            'license_plate.max' => 'Bi\u1ec3n s\u1ed1 xe kh\u00f4ng \u0111\u01b0\u1ee3c v\u01b0\u1ee3t qu\u00e1 20 k\u00fd t\u1ef1.',
            'license_plate.regex' => 'Bi\u1ec3n s\u1ed1 xe kh\u00f4ng \u0111\u00fang \u0111\u1ecbnh d\u1ea1ng Vi\u1ec7t Nam (V\u00ed d\u1ee5: 59A-123.45).',
            'full_name.required' => 'H\u1ecd v\u00e0 t\u00ean l\u00e0 b\u1eaft bu\u1ed9c.',
            'full_name.max' => 'H\u1ecd v\u00e0 t\u00ean kh\u00f4ng \u0111\u01b0\u1ee3c v\u01b0\u1ee3t qu\u00e1 255 k\u00fd t\u1ef1.',
            'birth_year.required' => 'N\u0103m sinh l\u00e0 b\u1eaft bu\u1ed9c.',
            'birth_year.integer' => 'N\u0103m sinh ph\u1ea3i l\u00e0 s\u1ed1 nguy\u00ean.',
            'birth_year.min' => 'N\u0103m sinh ph\u1ea3i l\u1edbn h\u01a1n ho\u1eb7c b\u1eb1ng 1900.',
            'birth_year.max' => 'N\u0103m sinh kh\u00f4ng th\u1ec3 l\u1edbn h\u01a1n n\u0103m hi\u1ec7n t\u1ea1i.',
            'address.required' => '\u0110\u1ecba ch\u1ec9 l\u00e0 b\u1eaft bu\u1ed9c.',
            'violation_type.required' => 'L\u1ed7i vi ph\u1ea1m l\u00e0 b\u1eaft bu\u1ed9c.',
        ];
    }
}
