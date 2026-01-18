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
            'birth_date' => ['required', 'date', 'before_or_equal:today', 'after:1900-01-01'],
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
            'birth_date.required' => 'Ngày sinh là bắt buộc.',
            'birth_date.date' => 'Ngày sinh không đúng định dạng.',
            'birth_date.before_or_equal' => 'Ngày sinh không thể là ngày trong tương lai.',
            'birth_date.after' => 'Ngày sinh phải sau ngày 01/01/1900.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'violation_type.required' => 'Lỗi vi phạm là bắt buộc.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Hình ảnh không được vượt quá 5MB.',
        ];
    }
}
