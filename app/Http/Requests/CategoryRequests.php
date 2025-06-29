<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequests extends FormRequest
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
    public function rules()
    {
        return [
            'ten' => 'required|string|max:255',
            'trang_thai' => 'required|in:active,inactive', // hoặc 'boolean' nếu chỉ có 0 và 1
        ];
    }

    public function messages()
    {
        return [
            'ten.required' => 'Tên danh mục không được bỏ trống',
            'ten.string' => 'Tên danh mục phải là chuỗi',
            'ten.max' => 'Tên danh mục tối đa 255 kí tự',
            'trang_thai.required' => 'Trạng thái không được bỏ trống',
            'trang_thai.in' => 'Trạng thái chỉ có thể là hoạt động hoặc không hoạt động',
        ];
    }
}