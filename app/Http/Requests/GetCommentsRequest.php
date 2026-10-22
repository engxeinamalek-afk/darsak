<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GetCommentsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limit' => ['required', 'integer' , 'min:1', 'max:50']
        ];
    }
    public function messages(): array
    {
        return [
            'limit.required' => 'حقل عدد العناصر مطلوب',
            'limit.integer' => 'يجب ادخال رقم صحيح',
            'limit.min' => 'يجب حلب تعليق واحد على الاقل',
            'limit.max' => 'تجاوزت الحد الممكن'
        ];
    }
}
