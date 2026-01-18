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
            'license_plate' => ['required', 'string', 'max:50'],
            'full_name' => ['required', 'string', 'max:255'],
            'birth_year' => [
                'required', 
                'integer', 
                'min:1900', 
                'max:' . date('Y')
            ],
            'address' => ['required', 'string'],
            'violation_type' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'violation_date.required' => 'Ngày vi phạm là bắt buộc.',
            'violation_date.date' => 'Ngày vi phạm không đúng định dạng.',
            'violation_date.before_or_equal' => 'Ngày vi phạm không thể là ngày trong tương lai.',
            'license_plate.required' => 'Biển số xe là bắt buộc.',
            'license_plate.max' => 'Biển số xe không được vượt quá 50 ký tự.',
            'full_name.required' => 'Họ và tên là bắt buộc.',
            'full_name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'birth_year.required' => 'Năm sinh là bắt buộc.',
            'birth_year.integer' => 'Năm sinh phải là số nguyên.',
            'birth_year.min' => 'Năm sinh phải lớn hơn hoặc bằng 1900.',
            'birth_year.max' => 'Năm sinh không thể lớn hơn năm hiện tại.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'violation_type.required' => 'Lỗi vi phạm là bắt buộc.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Hình ảnh không được vượt quá 5MB.',
        ];
    }
}
